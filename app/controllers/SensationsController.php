<?php

class SensationsController extends BaseController {

        public function getIndex()
        {
		$data = Sensation::curuser()->orderBy('name', 'ASC')->get();

                if (!$data)
                {
                        return Redirect::action('DashboardController@getIndex')
                                ->with('alert-warning', 'Sensations not found.');
                }

                /* Everything ok */
                return View::make('sensations.index')->with('sensations', $data);
        }

        public function getCreate()
        {
                return View::make('sensations.create');
        }

        public function postCreate()
        {
                $input = Input::all();

                $input['name'] = ucfirst(strtolower($input['name']));

                $rules = array(
                        'name' => 'required|unique:sensations,name',
                );

                $validator = Validator::make($input, $rules);

                if ($validator->fails())
                {
                        return Redirect::back()->withInput()->withErrors($validator);
                } else {

                        /* Create a sensation */
                        $sensation_data = array(
                                'name' => $input['name'],
                        );
                        $sensation = Sensation::create($sensation_data);
			if (!$sensation)
			{
			        return Redirect::back()->withInput()
                                        ->with('alert-danger', 'Failed to create sensation.');
			}

                        /* Everything ok */
                        return Redirect::action('SensationsController@getIndex')
                                ->with('alert-success', 'Sensation successfully created.');
                }
        }

        public function getEdit($id)
        {
		$data = Sensation::curuser()->find($id);

                if (!$data)
                {
                        return Redirect::action('SensationsController@getIndex')
                                ->with('alert-warning', 'Sensation not found.');
                }

                return View::make('sensations.edit')->with('sensation', $data);
        }

        public function postEdit($id)
        {
                $data = Sensation::curuser()->find($id);

                if (!$data)
                {
                        return Redirect::action('SensationsController@getIndex')
                                ->with('alert-warning', 'Sensation not found.');
                }

                $input = Input::all();

                $input['name'] = ucfirst(strtolower($input['name']));

                $rules = array(
                        'name' => 'required|unique:sensations,name,'.$id,
                );

                $validator = Validator::make($input, $rules);

                if ($validator->fails())
                {
                        return Redirect::back()->withInput()->withErrors($validator);
                } else {

                        /* Update a sensation */
                        $data->name = $input['name'];
			if (!$data->save())
			{
			        return Redirect::back()->withInput()
                                        ->with('alert-danger', 'Failed to udpate sensation.');
			}

                        /* Everything ok */
                        return Redirect::action('SensationsController@getIndex')
                                ->with('alert-success', 'Sensation successfully udpated.');
                }
        }

        public function getDelete($id)
        {
                $data = Sensation::curuser()->find($id);

                if (!$data)
                {
                        return Redirect::action('SensationsController@getIndex')
                                ->with('alert-warning', 'Sensation not found.');
                }

                /* Check if sensation is already in use */
                $count = CbtSensation::where('sensation_id', '=', $id)->count() > 0;
                if ($count > 0)
                {
                        return Redirect::action('SensationsController@getIndex')
                                ->with('alert-warning', 'Failed to delete sensation since it is already in use at ' . $count . ' place(s).');
                }

                /* Delete a sensation */
		if (!$data->delete())
		{
		        return Redirect::back()->withInput()
                                ->with('alert-danger', 'Failed to delete sensation.');
		}

                /* Everything ok */
                return Redirect::action('SensationsController@getIndex')
                        ->with('alert-success', 'Sensation successfully deleted.');
        }
}
