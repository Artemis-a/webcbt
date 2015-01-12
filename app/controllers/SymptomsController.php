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

class SymptomsController extends BaseController {

        public function getIndex()
        {
                $user = User::find(Auth::id());

                $symptoms_list[Config::get('webcbt.SYMPTOM_1')] =
                        Symptom::curuser()->orderBy('name', 'ASC')
                        ->where('type', '=', 1)->get();

                $symptoms_list[Config::get('webcbt.SYMPTOM_2')] =
                        Symptom::curuser()->orderBy('name', 'ASC')
                        ->where('type', '=', 2)->get();

                return View::make('symptoms.index')
                        ->with('symptoms_list', $symptoms_list)
                        ->with('dateformat', $user->dateformat);
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
                        'type' => 'required|in:1,2',
                );

                $validator = Validator::make($input, $rules);

                if ($validator->fails())
                {
                        return Redirect::back()->withInput()->withErrors($validator);
                }
                else
                {

                        /* Create a symptom */
                        $symptom_data = array(
                                'name' => $input['name'],
                                'type' => $input['type'],
                        );
                        $symptom = Symptom::create($symptom_data);
			if (!$symptom)
			{
			        return Redirect::back()->withInput()
                                        ->with('alert-danger', 'Failed to create physical symptom.');
			}

                        return Redirect::action('SymptomsController@getIndex')
                                ->with('alert-success', 'Physical symptom successfully created.');
                }
        }

        public function getEdit($id)
        {
		$symptom = Symptom::curuser()->find($id);

                if (!$symptom)
                {
                        return Redirect::action('SymptomsController@getIndex')
                                ->with('alert-danger', 'Physical symptom not found.');
                }

                return View::make('symptoms.edit')->with('symptom', $symptom);
        }

        public function postEdit($id)
        {
                $symptom = Symptom::curuser()->find($id);

                if (!$symptom)
                {
                        return Redirect::action('SymptomsController@getIndex')
                                ->with('alert-danger', 'Physical symptom not found.');
                }

                $input = Input::all();

                $input['name'] = ucfirst(strtolower($input['name']));

                $rules = array(
                        'name' => 'required|unique:symptoms,name,'.$id,
                        'type' => 'required|in:1,2',
                );

                $validator = Validator::make($input, $rules);

                if ($validator->fails())
                {
                        return Redirect::back()->withInput()->withErrors($validator);
                }
                else
                {
                        /* Update a symptom */
                        $symptom->name = $input['name'];
                        $symptom->type = $input['type'];
			if (!$symptom->save())
			{
			        return Redirect::back()->withInput()
                                        ->with('alert-danger', 'Failed to udpate physical symptom.');
			}

                        return Redirect::action('SymptomsController@getIndex')
                                ->with('alert-success', 'Physical symptom successfully udpated.');
                }
        }

        public function deleteDestroy($id)
        {
                $symptom = Symptom::curuser()->find($id);

                if (!$symptom)
                {
                        return Redirect::action('SymptomsController@getIndex')
                                ->with('alert-danger', 'Physical symptom not found.');
                }

                /* Check if symptom is already in use */
                $count = CbtSymptom::where('symptom_id', '=', $id)->count();
                if ($count > 0)
                {
                        return Redirect::action('SymptomsController@getIndex')
                                ->with('alert-danger', 'Failed to delete physical symptom since it is already in use at ' . $count . ' place(s).');
                }

                /* Delete a symptom */
		if (!$symptom->delete())
		{
		        return Redirect::action('SymptomsController@getIndex')
                                ->with('alert-danger', 'Failed to delete physical symptom.');
                }

                return Redirect::action('SymptomsController@getIndex')
                        ->with('alert-success', 'Physical symptom deleted successfully.');
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

                $all_symptoms = CbtSymptom::where('symptom_id', '=', $id)
                        ->leftJoin('cbts', 'cbt_symptoms.cbt_id', '=', 'cbts.id')
                        ->orderBy('date', 'ASC')
                        ->select('cbt_symptoms.*', 'cbts.date as cbts_date', 'cbts.id as cbts_id')
                        ->get();

                /**
                 * Create a collection of the format
                 * array('some-date' =>
                 *      array(
                 *           'id1' => array('B' => 7, 'A' => 3)
                 *           'id2' => array('B' => 9, 'A' => 2)
                 *      )
                 * );
                 */
                $symptoms_collection = array();

                $before_count = 0;
                $after_count = 0;
                foreach ($all_symptoms as $data)
                {
                        if ($data->status == 'B')
                        {
                                $symptoms_collection[$data->cbts_date][$data->cbts_id]['B'] = $data->intensity;
                                $before_count++;
                        }
                        else if ($data->status == 'A')
                        {
                                $symptoms_collection[$data->cbts_date][$data->cbts_id]['A'] = $data->intensity;
                                $after_count++;
                        }
                }

                $before_dataset = '[';
                $after_dataset = '[';
                $labelset = '[';
                foreach ($symptoms_collection as $cbt_date => $symptoms_data)
                {
                        foreach ($symptoms_data as $cbt_data)
                        {
                                $labelset .= '"' .
                                        date_format(
                                                date_create_from_format('Y-m-d H:i:s', $cbt_date),
                                                explode('|', $user->dateformat)[0]
                                        ) .
                                        '",';

                                if (isset($cbt_data['B']))
                                {
                                        $before_dataset .= '"' . $cbt_data['B'] . '",';
                                }
                                else
                                {
                                        $before_dataset .= 'null,';
                                }
                                if (isset($cbt_data['A']))
                                {
                                        $after_dataset .= '"' . $cbt_data['A'] . '",';
                                }
                                else
                                {
                                        $after_dataset .= 'null,';
                                }
                        }
                }
                $before_dataset .= ']';
                $after_dataset .= ']';
                $labelset .= ']';

                if ($before_count == 0 && $after_count == 0)
                {
		        return Redirect::action('SymptomsController@getIndex')
                                ->with('alert-danger', 'No data to show.');
                }
                if ($before_count <= 1 && $after_count <= 1)
                {
                        $chart_type = 'bar';
                }
                else
                {
                        $chart_type = 'line';
                }

                return View::make('symptoms.stats')
                        ->with('dateformat', $user->dateformat)
                        ->with('symptom', $symptom)
                        ->with('chart_type', $chart_type)
                        ->with('labelset', $labelset)
                        ->with('before_dataset', $before_dataset)
                        ->with('after_dataset', $after_dataset);
        }
}
