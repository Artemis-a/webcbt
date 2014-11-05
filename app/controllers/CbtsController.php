<?php

class CbtsController extends BaseController {

        public function getIndex()
        {
                Auth::loginUsingId(1);

		$data = Cbt::curuser()->orderBy('date', 'DESC')->get();

		if ($data)
		{
                        return View::make('cbts.index')->with('cbts', $data);
		}

        	App::abort(401, 'Failed to fetch data.');
        }

        public function getCreate()
        {
                $emotions_list = array(0 => 'Please select...') +
                        Emotion::curuser()->orderBy('name', 'ASC')->lists('name', 'id');

                return View::make('cbts.create')
                        ->with('emotions_list', $emotions_list);
        }

        public function postCreate()
        {
                $input = Input::all();
                $temp1 = date_create_from_format('d M Y H:i A', $input['date']);
                $input['date'] = date_format($temp1, 'Y-m-d H:i:s');

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
                                'date' => $input['date'],
                                'situation' => $input['situation']
                        );
                        $cbt = Cbt::create($cbt_data);
			if (!$cbt)
			{
			        return Redirect::back()->withInput()
                                        ->with('alert-danger', 'Failed to add CBT entry.');
			}

                        /* Add thoughts */
                        $thoughts_input = array();
                        foreach ($input['thoughts'] as $row)
                        {
                                $row = trim($row);
                                if (strlen($row) > 0)
                                {
                                        $thoughts_input[] = array(
                                                'thought' => $row,
                                                'certian_before' => 0,
                                                'is_challenged' => 0,
                                                'evidence_for' => '',
                                                'evidence_against' => '',
                                                'balanced_thoughts' => '',
                                                'certian_after' => 0
                                        );
                                }
                        }

                        foreach ($thoughts_input as $thought_data)
                        {
                                $thought = new Thought($thought_data);
                                $thought->cbt()->associate($cbt);
                                if (!$thought->save())
                                {
			                return Redirect::back()->withInput()
                                                ->with('alert-danger', 'Failed to add thoughts.');
                                }
                        }

                        /* Add feelings */
                        $feelings_input = array();
                        $intensity = $input['intensity'];
                        foreach ($input['feelings'] as $row_id => $row)
                        {
                                if (!empty($row))
                                {
                                        $feelings_input[] = array(
                                                'emotion_id' => $row,
                                                'percent' => $intensity[$row_id],
                                                'before_after' => 0
                                        );
                                }
                        }

                        foreach ($feelings_input as $feelings_data)
                        {
                                $feeling = new Feeling($feelings_data);
                                $feeling->cbt()->associate($cbt);
                                if (!$feeling->save())
                                {
			                return Redirect::back()->withInput()
                                                ->with('alert-danger', 'Failed to add feelings.');
                                }
                        }

                        /* Add behaviours */
                        $behaviours_input = array();
                        foreach ($input['behaviours'] as $row)
                        {
                                $row = trim($row);
                                if (strlen($row) > 0)
                                {
                                        $behaviours_input[] = array(
                                                'behaviour' => $row,
                                                'before_after' => 0
                                        );
                                }
                        }

                        foreach ($behaviours_input as $behaviours_data)
                        {
                                $behaviour = new Behaviour($behaviours_data);
                                $behaviour->cbt()->associate($cbt);
                                if (!$behaviour->save())
                                {
			                return Redirect::back()->withInput()
                                                ->with('alert-danger', 'Failed to add behaviours.');
                                }
                        }

                        /* Everything ok */
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-success', 'CBT entry added.');
                }
        }
}
