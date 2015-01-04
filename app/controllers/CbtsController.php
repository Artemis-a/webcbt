<?php
/**
 * The MIT License (MIT)
 *
 * WebCBT - Web based Cognitive Behavioral Therapy tool
 *
 * http://webcbt.github.io
 *
 * Copyright (c) 2014 Prashant Shah <pshah.webcbt@gmail.com>
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

class CbtsController extends BaseController {

        public function __construct()
        {
                $user = User::find(Auth::id());
                $this->dateformat = $user->dateformat;
        }

        public function getIndex()
        {
		$data = Cbt::curuser()->orderBy('date', 'DESC')->get();

		if ($data)
		{
                        return View::make('cbts.index')
                                ->with('dateformat', $this->dateformat)
                                ->with('cbts', $data);
		}

		return Redirect::action('DashboardController@getIndex')
			->with('alert-danger', 'No data.');
        }

        public function getCreate()
        {
                $feelings_list = array(0 => 'Please select...') +
                        Feeling::curuser()->orderBy('name', 'ASC')->lists('name', 'id');

                $symptoms_list = array(0 => 'Please select...') +
                        Symptom::curuser()->orderBy('name', 'ASC')->lists('name', 'id');

                return View::make('cbts.create')
                        ->with('dateformat', $this->dateformat)
                        ->with('feelings_list', $feelings_list)
                        ->with('symptoms_list', $symptoms_list);
        }

        public function postCreate()
        {
                $input = Input::all();

                $temp = date_create_from_format(
                        explode('|', $this->dateformat)[0] . ' h:i A',
                        $input['date']
                );
                $date = date_format($temp, 'Y-m-d H:i:s');

                $rules = array(
                        'date' => 'required|date',
                        'situation' => 'required|min:3'
                );

                $validator = Validator::make($input, $rules);

                if ($validator->fails())
                {
                        return Redirect::back()->withInput()->withErrors($validator);
                } else {

                        /* Create a CBT entry */
                        $cbt_data = array(
                                'date' => $date,
                                'situation' => ucfirst($input['situation']),
                                'is_resolved' => 0,
                        );
                        $cbt = Cbt::create($cbt_data);
			if (!$cbt)
			{
			        return Redirect::back()->withInput()
                                        ->with('alert-danger', 'Failed to add CBT entry.');
			}

                        /* Add thoughts */
                        $thoughts = array();
                        foreach ($input['thoughts'] as $row)
                        {
                                $row = trim($row);
                                if (strlen($row) > 0)
                                {
                                        $thoughts[] = array(
                                                'thought' => ucfirst($row),
                                                'is_challenged' => 0,
                                                'dispute' => '',
                                                'balanced_thoughts' => '',
                                        );
                                }
                        }

                        foreach ($thoughts as $data)
                        {
                                $cbtThought = new CbtThought($data);
                                $cbtThought->cbt()->associate($cbt);
                                if (!$cbtThought->save())
                                {
			                return Redirect::back()->withInput()
                                                ->with('alert-danger', 'Failed to add thoughts.');
                                }
                        }

                        /* Add feelings */
                        $feelings = array();
                        $feelingsintensity = $input['feelingsintensity'];
                        foreach ($input['feelings'] as $row_id => $row)
                        {
                                if (!empty($row))
                                {
                                        $feelings[] = array(
                                                'feeling_id' => $row,
                                                'intensity' => $feelingsintensity[$row_id],
                                                'status' => 'B',
                                        );
                                }
                        }

                        foreach ($feelings as $data)
                        {
                                $cbt_feeling = new CbtFeeling($data);
                                $cbt_feeling->cbt()->associate($cbt);
                                if (!$cbt_feeling->save())
                                {
			                return Redirect::back()->withInput()
                                                ->with('alert-danger', 'Failed to add feelings.');
                                }
                        }

                        /* Add symptom */
                        $symptoms = array();
                        $symptomsintensity = $input['symptomsintensity'];
                        foreach ($input['symptoms'] as $row_id => $row)
                        {
                                if (!empty($row))
                                {
                                        $symptoms[] = array(
                                                'symptom_id' => $row,
                                                'intensity' => $symptomsintensity[$row_id],
                                                'status' => 'B',
                                        );
                                }
                        }

                        foreach ($symptoms as $data)
                        {
                                $cbt_symptom = new CbtSymptom($data);
                                $cbt_symptom->cbt()->associate($cbt);
                                if (!$cbt_symptom->save())
                                {
			                return Redirect::back()->withInput()
                                                ->with('alert-danger', 'Failed to add physical symptom.');
                                }
                        }

                        /* Add behaviours */
                        $behaviours = array();
                        foreach ($input['behaviours'] as $row)
                        {
                                $row = trim($row);
                                if (strlen($row) > 0)
                                {
                                        $behaviours[] = array(
                                                'behaviour' => ucfirst($row),
                                                'status' => 'B',
                                        );
                                }
                        }

                        foreach ($behaviours as $data)
                        {
                                $cbt_behaviour = new CbtBehaviour($data);
                                $cbt_behaviour->cbt()->associate($cbt);
                                if (!$cbt_behaviour->save())
                                {
			                return Redirect::back()->withInput()
                                                ->with('alert-danger', 'Failed to add behaviours.');
                                }
                        }

                        /* Everything ok */
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-success', 'CBT exercise added successfully.');
                }
        }

        public function getPostdispute($id)
        {
		$cbt = Cbt::find($id);
                if (!$cbt)
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Cbt exercise not found.');
                }

                if ($cbt['user_id'] != Auth::id())
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Invalid access.');
                }

                $feelings_list = array(0 => 'Please select...') +
                        Feeling::curuser()->orderBy('name', 'ASC')->lists('name', 'id');

                $symptoms_list = array(0 => 'Please select...') +
                        Symptom::curuser()->orderBy('name', 'ASC')->lists('name', 'id');

                return View::make('cbts.postdispute')
                        ->with('cbt', $cbt)
                        ->with('dateformat', $this->dateformat)
                        ->with('feelings_list', $feelings_list)
                        ->with('symptoms_list', $symptoms_list);
        }

        public function postPostdispute($id)
        {
		$cbt = Cbt::find($id);
                if (!$cbt)
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Cbt exercise not found.');
                }

                if ($cbt['user_id'] != Auth::id())
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Invalid access.');
                }

                $input = Input::all();

                $rules = array(
                );

                $validator = Validator::make($input, $rules);

                if ($validator->fails())
                {
                        return Redirect::back()->withInput()->withErrors($validator);
                } else {

                        /* Delete old and then add feelings */
                        CbtFeeling::where('cbt_id', '=', $id)
                                ->where('status', '=', 'A')->delete();

                        $feelings = array();
                        $feelingsintensity = $input['feelingsintensity'];
                        foreach ($input['feelings'] as $row_id => $row)
                        {
                                if (!empty($row))
                                {
                                        $feelings[] = array(
                                                'feeling_id' => $row,
                                                'intensity' => $feelingsintensity[$row_id],
                                                'status' => 'A',
                                        );
                                }
                        }

                        foreach ($feelings as $data)
                        {
                                $cbt_feeling = new CbtFeeling($data);
                                $cbt_feeling->cbt()->associate($cbt);
                                if (!$cbt_feeling->save())
                                {
			                return Redirect::back()->withInput()
                                                ->with('alert-danger', 'Failed to add feelings.');
                                }
                        }

                        /* Delete old and then add symptoms */
                        CbtSymptom::where('cbt_id', '=', $id)
                                ->where('status', '=', 'A')->delete();

                        $symptoms = array();
                        $symptomsintensity = $input['symptomsintensity'];
                        foreach ($input['symptoms'] as $row_id => $row)
                        {
                                if (!empty($row))
                                {
                                        $symptoms[] = array(
                                                'symptom_id' => $row,
                                                'intensity' => $symptomsintensity[$row_id],
                                                'status' => 'A',
                                        );
                                }
                        }

                        foreach ($symptoms as $data)
                        {
                                $cbt_symptom = new CbtSymptom($data);
                                $cbt_symptom->cbt()->associate($cbt);
                                if (!$cbt_symptom->save())
                                {
			                return Redirect::back()->withInput()
                                                ->with('alert-danger', 'Failed to add physical symptoms.');
                                }
                        }

                        /* Delete old and then add behaviours */
                        CbtBehaviour::where('cbt_id', '=', $id)
                                ->where('status', '=', 'A')->delete();

                        $behaviours = array();
                        foreach ($input['behaviours'] as $row)
                        {
                                $row = trim($row);
                                if (strlen($row) > 0)
                                {
                                        $behaviours[] = array(
                                                'behaviour' => ucfirst($row),
                                                'status' => 'A',
                                        );
                                }
                        }

                        foreach ($behaviours as $data)
                        {
                                $cbt_behaviour = new CbtBehaviour($data);
                                $cbt_behaviour->cbt()->associate($cbt);
                                if (!$cbt_behaviour->save())
                                {
			                return Redirect::back()->withInput()
                                                ->with('alert-danger', 'Failed to add behaviours.');
                                }
                        }

                        /* Everything ok */
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-success', 'CBT exercise completed successfully.');
                }
        }

        public function putResolved($id)
        {
		$cbt = Cbt::find($id);
                if (!$cbt)
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Cbt exercise not found.');
                }

                if ($cbt['user_id'] != Auth::id())
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Invalid access.');
                }

                $cbt->is_resolved = 1;

                if ($cbt->save())
                {
	                return Redirect::action('CbtsController@getIndex')
                                ->with('alert-success', 'CBT exercise marked as resolved.');
                } else {
	                return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Failed to mark CBT exercise as resolved.');
                }
        }

        public function putUnresolved($id)
        {
		$cbt = Cbt::find($id);
                if (!$cbt)
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Cbt exercise not found.');
                }

                if ($cbt['user_id'] != Auth::id())
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Invalid access.');
                }

                $cbt->is_resolved = 0;

                if ($cbt->save())
                {
	                return Redirect::action('CbtsController@getIndex')
                                ->with('alert-success', 'CBT exercise marked as unresolved.');
                } else {
	                return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Failed to mark CBT exercise as unresolved.');
                }
        }

        public function getEdit($id)
        {
		$cbt = Cbt::find($id);
                if (!$cbt)
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Cbt exercise not found.');
                }

                if ($cbt['user_id'] != Auth::id())
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Invalid access.');
                }

                $temp = date_create_from_format('Y-m-d H:i:s', $cbt->date);
                $date = date_format($temp, explode('|', $this->dateformat)[0] . ' h:i A');

                $feelings_list = array(0 => 'Please select...') +
                        Feeling::curuser()->orderBy('name', 'ASC')->lists('name', 'id');

                $symptoms_list = array(0 => 'Please select...') +
                        Symptom::curuser()->orderBy('name', 'ASC')->lists('name', 'id');

                return View::make('cbts.edit')
                        ->with('date', $date)
                        ->with('dateformat', $this->dateformat)
                        ->with('cbt', $cbt)
                        ->with('feelings_list', $feelings_list)
                        ->with('symptoms_list', $symptoms_list);
        }

        public function postEdit($id)
        {
		$cbt = Cbt::find($id);
                if (!$cbt)
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Cbt exercise not found.');
                }

                if ($cbt['user_id'] != Auth::id())
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Invalid access.');
                }

                $input = Input::all();

                $temp = date_create_from_format(
                        explode('|', $this->dateformat)[0] . ' h:i A',
                        $input['date']
                );

                $date = date_format($temp, 'Y-m-d H:i:s');

                $rules = array(
                        'date' => 'required|date',
                        'situation' => 'required|min:3'
                );

                $validator = Validator::make($input, $rules);

                if ($validator->fails())
                {
                        return Redirect::back()->withInput()->withErrors($validator);
                } else {

                        /* Update CBT exercise */
                        $cbt->date = $date;
                        $cbt->situation = ucfirst($input['situation']);
                        if (!$cbt->save())
                        {
                                return Redirect::back()->withInput()
                                        ->with('alert-danger', 'Failed to update CBT exercise.');
                        }

                        /* Update old and add new thoughts */
                        $new_thoughts = array();
                        foreach ($input['thoughts'] as $index => $row)
                        {
                                if ($index < 100)
                                {
                                        /* If index < 100 then its a new thought */
                                        $row = trim($row);
                                        if (strlen($row) > 0)
                                        {
                                                $new_thoughts[] = array(
                                                        'thought' => ucfirst($row),
                                                        'is_challenged' => 0,
                                                        'dispute' => '',
                                                        'balanced_thoughts' => '',
                                                );
                                        }
                                } else {
                                        /* if index >= 100 then its a old thought */
                                        $thought = CbtThought::find($index);

                                        /* Validate thought */
                                        if (!$thought)
                                        {
                                                continue;
                                        }
                                        if ($thought->cbt_id != $id)
                                        {
                                                continue;
                                        }

                                        $row = trim($row);
                                        if (strlen($row) <= 0)
                                        {
                                                /* If empty string, delete thought */
                                                if (!$thought->delete())
                                                {
                                                        return Redirect::back()->withInput()
                                                                ->with('alert-danger', 'Failed to delete old thoughts.');
                                                }
                                        } else {
                                                /* If changed, update thought */
                                                if ($thought->thought == ucfirst($row))
                                                {
                                                        /* No changes in the thought */
                                                        continue;
                                                }
                                                /* Update thought */
                                                $thought->thought = ucfirst($row);
                                                if (!$thought->save())
                                                {
                                                        return Redirect::back()->withInput()
                                                                ->with('alert-danger', 'Failed to update old thoughts.');
                                                }
                                        }
                                }
                        }

                        foreach ($new_thoughts as $data)
                        {
                                $cbtThought = new CbtThought($data);
                                $cbtThought->cbt()->associate($cbt);
                                if (!$cbtThought->save())
                                {
			                return Redirect::back()->withInput()
                                                ->with('alert-danger', 'Failed to add thoughts.');
                                }
                        }

                        /* Delete old and then add feelings */
                        CbtFeeling::where('cbt_id', '=', $id)
                                ->where('status', '=', 'B')->delete();

                        $feelings = array();
                        $feelingsintensity = $input['feelingsintensity'];
                        foreach ($input['feelings'] as $row_id => $row)
                        {
                                if (!empty($row))
                                {
                                        $feelings[] = array(
                                                'feeling_id' => $row,
                                                'intensity' => $feelingsintensity[$row_id],
                                                'status' => 'B',
                                        );
                                }
                        }

                        foreach ($feelings as $data)
                        {
                                $cbt_feeling = new CbtFeeling($data);
                                $cbt_feeling->cbt()->associate($cbt);
                                if (!$cbt_feeling->save())
                                {
			                return Redirect::back()->withInput()
                                                ->with('alert-danger', 'Failed to add feelings.');
                                }
                        }

                        /* Delete old and then add symptom */
                        CbtSymptom::where('cbt_id', '=', $id)
                                ->where('status', '=', 'B')->delete();

                        $symptoms = array();
                        $symptomsintensity = $input['symptomsintensity'];
                        foreach ($input['symptoms'] as $row_id => $row)
                        {
                                if (!empty($row))
                                {
                                        $symptoms[] = array(
                                                'symptom_id' => $row,
                                                'intensity' => $symptomsintensity[$row_id],
                                                'status' => 'B',
                                        );
                                }
                        }

                        foreach ($symptoms as $data)
                        {
                                $cbt_symptom = new CbtSymptom($data);
                                $cbt_symptom->cbt()->associate($cbt);
                                if (!$cbt_symptom->save())
                                {
			                return Redirect::back()->withInput()
                                                ->with('alert-danger', 'Failed to add physical symptom.');
                                }
                        }

                        /* Delete old and then add behaviours */
                        CbtBehaviour::where('cbt_id', '=', $id)
                                ->where('status', '=', 'B')->delete();

                        $behaviours = array();
                        foreach ($input['behaviours'] as $row)
                        {
                                $row = trim($row);
                                if (strlen($row) > 0)
                                {
                                        $behaviours[] = array(
                                                'behaviour' => ucfirst($row),
                                                'status' => 'B',
                                        );
                                }
                        }

                        foreach ($behaviours as $data)
                        {
                                $cbt_behaviour = new CbtBehaviour($data);
                                $cbt_behaviour->cbt()->associate($cbt);
                                if (!$cbt_behaviour->save())
                                {
			                return Redirect::back()->withInput()
                                                ->with('alert-danger', 'Failed to add behaviours.');
                                }
                        }

                        /* Everything ok */
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-success', 'CBT exercise updated successfully.');
                }

        }

        public function deleteDestroy($id)
        {
		$cbt = Cbt::find($id);
                if (!$cbt)
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Cbt exercise not found.');
                }

                if ($cbt['user_id'] != Auth::id())
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Invalid access.');
                }

                if ($cbt->delete())
                {
	                return Redirect::action('CbtsController@getIndex')
                                ->with('alert-success', 'CBT exercise deleted successfully.');
                } else {
	                return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Failed to delete CBT exercise.');
                }
        }

        public function getAnalysis($id)
        {
		$cbt = Cbt::find($id);
                if (!$cbt)
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Cbt exercise not found.');
                }

                if ($cbt['user_id'] != Auth::id())
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Invalid access.');
                }

                $temp = date_create_from_format('Y-m-d H:i:s', $cbt->date);
                $date = date_format($temp, explode('|', $this->dateformat)[0] . ' h:i A');

                $feelings_list = array(0 => 'Please select...') +
                        Feeling::curuser()->orderBy('name', 'ASC')->lists('name', 'id');

                $symptoms_list = array(0 => 'Please select...') +
                        Symptom::curuser()->orderBy('name', 'ASC')->lists('name', 'id');

                return View::make('cbts.analysis')
                        ->with('date', $date)
                        ->with('dateformat', $this->dateformat)
                        ->with('cbt', $cbt)
                        ->with('feelings_list', $feelings_list)
                        ->with('symptoms_list', $symptoms_list);
        }
}
