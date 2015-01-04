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

class FeelingsController extends BaseController {

        public function getIndex()
        {
		$data = Feeling::curuser()->orderBy('name', 'ASC')->get();

                if (!$data)
                {
                        return Redirect::action('DashboardController@getIndex')
                                ->with('alert-danger', 'Feelings not found.');
                }

                /* Everything ok */
                return View::make('feelings.index')->with('feelings', $data);
        }

        public function getCreate()
        {
                return View::make('feelings.create');
        }

        public function postCreate()
        {
                $input = Input::all();

                $input['name'] = ucfirst(strtolower($input['name']));

                $rules = array(
                        'name' => 'required|unique:feelings,name',
                );

                $validator = Validator::make($input, $rules);

                if ($validator->fails())
                {
                        return Redirect::back()->withInput()->withErrors($validator);
                } else {

                        /* Create a feeling */
                        $feeling_data = array(
                                'name' => $input['name'],
                        );
                        $feeling = Feeling::create($feeling_data);
			if (!$feeling)
			{
			        return Redirect::back()->withInput()
                                        ->with('alert-danger', 'Failed to create feeling.');
			}

                        /* Everything ok */
                        return Redirect::action('FeelingsController@getIndex')
                                ->with('alert-success', 'Feeling successfully created.');
                }
        }

        public function getEdit($id)
        {
		$data = Feeling::curuser()->find($id);

                if (!$data)
                {
                        return Redirect::action('FeelingsController@getIndex')
                                ->with('alert-danger', 'Feeling not found.');
                }

                return View::make('feelings.edit')->with('feeling', $data);
        }

        public function postEdit($id)
        {
                $data = Feeling::curuser()->find($id);

                if (!$data)
                {
                        return Redirect::action('FeelingsController@getIndex')
                                ->with('alert-danger', 'Feeling not found.');
                }

                $input = Input::all();

                $input['name'] = ucfirst(strtolower($input['name']));

                $rules = array(
                        'name' => 'required|unique:feelings,name,'.$id,
                );

                $validator = Validator::make($input, $rules);

                if ($validator->fails())
                {
                        return Redirect::back()->withInput()->withErrors($validator);
                } else {

                        /* Update a feeling */
                        $data->name = $input['name'];
			if (!$data->save())
			{
			        return Redirect::back()->withInput()
                                        ->with('alert-danger', 'Failed to udpate feeling.');
			}

                        /* Everything ok */
                        return Redirect::action('FeelingsController@getIndex')
                                ->with('alert-success', 'Feeling successfully udpated.');
                }
        }

        public function deleteDestroy($id)
        {
                $data = Feeling::curuser()->find($id);

                if (!$data)
                {
                        return Redirect::action('FeelingsController@getIndex')
                                ->with('alert-danger', 'Feeling not found.');
                }

                /* Check if feeling is already in use */
                $count = CbtFeeling::where('feeling_id', '=', $id)->count() > 0;
                if ($count > 0)
                {
                        return Redirect::action('FeelingsController@getIndex')
                                ->with('alert-danger', 'Failed to delete feeling since it is already in use at ' . $count . ' place(s).');
                }

                /* Delete a feeling */
		if ($data->delete())
                {
                        return Redirect::action('FeelingsController@getIndex')
                                ->with('alert-success', 'Feeling deleted successfully.');
                } else {
		        return Redirect::action('FeelingsController@getIndex')
                                ->with('alert-danger', 'Failed to delete feeling.');
		}
        }

        public function getStats($id)
        {
		$feeling = Feeling::curuser()->find($id);

                if (!$feeling)
                {
                        return Redirect::action('FeelingsController@getIndex')
                                ->with('alert-danger', 'Feeling not found.');
                }

                $user = User::find(Auth::id());

                $all_feelings = CbtFeeling::where('feeling_id', '=', $id)
                        ->leftJoin('cbts', 'cbt_feelings.cbt_id', '=', 'cbts.id')
                        ->orderBy('date', 'ASC')
                        ->select('cbt_feelings.*', 'cbts.date as cbts_date', 'cbts.id as cbts_id')
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
                $feelings_collection = array();

                $before_count = 0;
                $after_count = 0;
                foreach ($all_feelings as $data)
                {
                        if ($data->status == 'B')
                        {
                                $feelings_collection[$data->cbts_date][$data->cbts_id]['B'] = $data->intensity;
                                $before_count++;
                        }
                        else if ($data->status == 'A')
                        {
                                $feelings_collection[$data->cbts_date][$data->cbts_id]['A'] = $data->intensity;
                                $after_count++;
                        }
                }

                $before_dataset = '[';
                $after_dataset = '[';
                $labelset = '[';
                foreach ($feelings_collection as $cbt_date => $feelings_data)
                {
                        foreach ($feelings_data as $cbt_data)
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
		        return Redirect::action('FeelingsController@getIndex')
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

                return View::make('feelings.stats')
                        ->with('dateformat', $user->dateformat)
                        ->with('feeling', $feeling)
                        ->with('chart_type', $chart_type)
                        ->with('labelset', $labelset)
                        ->with('before_dataset', $before_dataset)
                        ->with('after_dataset', $after_dataset);
        }
}
