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
		$data = Feeling::curuser()->find($id);

                if (!$data)
                {
                        return Redirect::action('FeelingsController@getIndex')
                                ->with('alert-danger', 'Feeling not found.');
                }

                $rawdataset = CbtFeeling::where('feeling_id', '=', $id)->get();

                if ($rawdataset->count() <= 0)
                {
                        return Redirect::action('FeelingsController@getIndex')
                                ->with('alert-danger', 'No data.');
                }

                return View::make('feelings.stats')
                        ->with('feeling', $data)
                        ->with('rawdataset', $rawdataset);
        }
}
