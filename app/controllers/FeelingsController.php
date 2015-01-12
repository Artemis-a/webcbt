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
                $user = User::find(Auth::id());

                $feelings_list[Config::get('webcbt.FEELING_1')] =
                        Feeling::curuser()->orderBy('name', 'ASC')
                        ->where('type', '=', 1)->get();

                $feelings_list[Config::get('webcbt.FEELING_2')] =
                        Feeling::curuser()->orderBy('name', 'ASC')
                        ->where('type', '=', 2)->get();

                return View::make('feelings.index')
                        ->with('feelings_list', $feelings_list)
                        ->with('dateformat', $user->dateformat);
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
                        'type' => 'required|in:1,2',
                );

                $validator = Validator::make($input, $rules);

                if ($validator->fails())
                {
                        return Redirect::back()->withInput()->withErrors($validator);
                }
                else
                {

                        /* Create a feeling */
                        $feeling_data = array(
                                'name' => $input['name'],
                                'type' => $input['type'],
                        );
                        $feeling = Feeling::create($feeling_data);
			if (!$feeling)
			{
			        return Redirect::back()->withInput()
                                        ->with('alert-danger', 'Failed to create feeling.');
			}

                        return Redirect::action('FeelingsController@getIndex')
                                ->with('alert-success', 'Feeling successfully created.');
                }
        }

        public function getEdit($id)
        {
		$feeling = Feeling::curuser()->find($id);

                if (!$feeling)
                {
                        return Redirect::action('FeelingsController@getIndex')
                                ->with('alert-danger', 'Feeling not found.');
                }

                return View::make('feelings.edit')->with('feeling', $feeling);
        }

        public function postEdit($id)
        {
                $feeling = Feeling::curuser()->find($id);

                if (!$feeling)
                {
                        return Redirect::action('FeelingsController@getIndex')
                                ->with('alert-danger', 'Feeling not found.');
                }

                $input = Input::all();

                $input['name'] = ucfirst(strtolower($input['name']));

                $rules = array(
                        'name' => 'required|unique:feelings,name,'.$id,
                        'type' => 'required|in:1,2',
                );

                $validator = Validator::make($input, $rules);

                if ($validator->fails())
                {
                        return Redirect::back()->withInput()->withErrors($validator);
                }
                else
                {

                        /* Update a feeling */
                        $feeling->name = $input['name'];
                        $feeling->type = $input['type'];
			if (!$feeling->save())
			{
			        return Redirect::back()->withInput()
                                        ->with('alert-danger', 'Failed to udpate feeling.');
			}

                        return Redirect::action('FeelingsController@getIndex')
                                ->with('alert-success', 'Feeling successfully udpated.');
                }
        }

        public function deleteDestroy($id)
        {
                $feeling = Feeling::curuser()->find($id);

                if (!$feeling)
                {
                        return Redirect::action('FeelingsController@getIndex')
                                ->with('alert-danger', 'Feeling not found.');
                }

                /* Check if feeling is already in use */
                $count = CbtFeeling::where('feeling_id', '=', $id)->count();
                if ($count > 0)
                {
                        return Redirect::action('FeelingsController@getIndex')
                                ->with('alert-danger', 'Failed to delete feeling since it is already in use at ' . $count . ' place(s).');
                }

                /* Delete a feeling */
		if (!$feeling->delete())
                {
		        return Redirect::action('FeelingsController@getIndex')
                                ->with('alert-danger', 'Failed to delete feeling.');
                }

                return Redirect::action('FeelingsController@getIndex')
                        ->with('alert-success', 'Feeling deleted successfully.');
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
