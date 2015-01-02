<?php
/**
 * The MIT License (MIT)
 *
 * WebCBT - Web based Cognitive Behavioral Therapy tool
 *
 * http://mindtools.github.io/webcbt/
 *
 * Copyright (c) 2014 Prashant Shah <pshah.mindtools@gmail.com>
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

class SymptomsController extends BaseController {

        public function getIndex()
        {
		$data = Symptom::curuser()->orderBy('name', 'ASC')->get();

                if (!$data)
                {
                        return Redirect::action('DashboardController@getIndex')
                                ->with('alert-danger', 'Physical symptoms not found.');
                }

                /* Everything ok */
                return View::make('symptoms.index')->with('symptoms', $data);
        }

        public function getCreate()
        {
                return View::make('symptoms.create');
        }

        public function postCreate()
        {
                $input = Input::all();

                $input['name'] = ucfirst(strtolower($input['name']));

                $rules = array(
                        'name' => 'required|unique:symptoms,name',
                );

                $validator = Validator::make($input, $rules);

                if ($validator->fails())
                {
                        return Redirect::back()->withInput()->withErrors($validator);
                } else {

                        /* Create a symptom */
                        $symptom_data = array(
                                'name' => $input['name'],
                        );
                        $symptom = Symptom::create($symptom_data);
			if (!$symptom)
			{
			        return Redirect::back()->withInput()
                                        ->with('alert-danger', 'Failed to create physical symptom.');
			}

                        /* Everything ok */
                        return Redirect::action('SymptomsController@getIndex')
                                ->with('alert-success', 'Physical symptom successfully created.');
                }
        }

        public function getEdit($id)
        {
		$data = Symptom::curuser()->find($id);

                if (!$data)
                {
                        return Redirect::action('SymptomsController@getIndex')
                                ->with('alert-danger', 'Physical symptom not found.');
                }

                return View::make('symptoms.edit')->with('symptom', $data);
        }

        public function postEdit($id)
        {
                $data = Symptom::curuser()->find($id);

                if (!$data)
                {
                        return Redirect::action('SymptomsController@getIndex')
                                ->with('alert-danger', 'Physical symptom not found.');
                }

                $input = Input::all();

                $input['name'] = ucfirst(strtolower($input['name']));

                $rules = array(
                        'name' => 'required|unique:symptoms,name,'.$id,
                );

                $validator = Validator::make($input, $rules);

                if ($validator->fails())
                {
                        return Redirect::back()->withInput()->withErrors($validator);
                } else {

                        /* Update a symptom */
                        $data->name = $input['name'];
			if (!$data->save())
			{
			        return Redirect::back()->withInput()
                                        ->with('alert-danger', 'Failed to udpate physical symptom.');
			}

                        /* Everything ok */
                        return Redirect::action('SymptomsController@getIndex')
                                ->with('alert-success', 'Physical symptom successfully udpated.');
                }
        }

        public function deleteDestroy($id)
        {
                $data = Symptom::curuser()->find($id);

                if (!$data)
                {
                        return Redirect::action('SymptomsController@getIndex')
                                ->with('alert-danger', 'Physical symptom not found.');
                }

                /* Check if symptom is already in use */
                $count = CbtSymptom::where('symptom_id', '=', $id)->count() > 0;
                if ($count > 0)
                {
                        return Redirect::action('SymptomsController@getIndex')
                                ->with('alert-danger', 'Failed to delete physical symptom since it is already in use at ' . $count . ' place(s).');
                }

                /* Delete a symptom */
		if ($data->delete())
		{
                        return Redirect::action('SymptomsController@getIndex')
                                ->with('alert-success', 'Physical symptom deleted successfully.');
                } else {
		        return Redirect::action('SymptomsController@getIndex')
                                ->with('alert-danger', 'Failed to delete physical symptom.');
		}
        }

        public function getStats($id)
        {
		$symptom = Symptom::curuser()->find($id);

                if (!$symptom)
                {
                        return Redirect::action('SymptomsController@getIndex')
                                ->with('alert-danger', 'Physical symptom not found.');
                }

                $user = User::find(Auth::id());

                $before_dataset = CbtSymptom::where('symptom_id', '=', $id)
                        ->where('when', '=', 'B')
                        ->leftJoin('cbts', 'cbt_symptoms.cbt_id', '=', 'cbts.id')
                        ->orderBy('date', 'ASC')
                        ->select('cbt_symptoms.*', 'cbts.date as date')
                        ->get();

                $after_dataset = CbtSymptom::where('symptom_id', '=', $id)
                        ->where('when', '=', 'A')
                        ->leftJoin('cbts', 'cbt_symptoms.cbt_id', '=', 'cbts.id')
                        ->orderBy('date', 'ASC')
                        ->select('cbt_symptoms.*', 'cbts.date as date')
                        ->get();

                if ($before_dataset->count() <= 0 && $after_dataset->count() <= 0)
                {
                        return Redirect::action('SymptomsController@getIndex')
                                ->with('alert-danger', 'No data.');
                }

                return View::make('symptoms.stats')
                        ->with('dateformat', $user->dateformat)
                        ->with('symptom', $symptom)
                        ->with('before_dataset', $before_dataset)
                        ->with('after_dataset', $after_dataset);
        }
}
