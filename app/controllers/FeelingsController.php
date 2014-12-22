<?php

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

        public function getDelete($id)
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
		if (!$data->delete())
		{
		        return Redirect::back()->withInput()
                                ->with('alert-danger', 'Failed to delete feeling.');
		}

                /* Everything ok */
                return Redirect::action('FeelingsController@getIndex')
                        ->with('alert-success', 'Feeling successfully deleted.');
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
