<?php

class ThoughtsController extends BaseController {

        public function getDispute($id)
        {
		$thought = CbtThought::find($id);
                if (!$thought)
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-warning', 'Thought not found.');
                }

                if ($thought->cbt['user_id'] != Auth::id()) {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-warning', 'Invalid access.');
                }

                $distortions_list = array(0 => 'Please select...') +
                        Distortion::orderBy('name', 'ASC')->lists('name', 'id');

                /* Everything ok */
                return View::make('thoughts.dispute')
                        ->with('thought', $thought)
                        ->with('distortions_list', $distortions_list);
        }

        public function postDispute($id)
        {
		$thought = CbtThought::find($id);
                if (!$thought)
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-warning', 'Thought not found.');
                }

                if ($thought->cbt['user_id'] != Auth::id()) {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-warning', 'Invalid access.');
                }

                $input = Input::all();

                $rules = array(
                );

                $validator = Validator::make($input, $rules);

                if ($validator->fails())
                {
                        return Redirect::back()->withInput()->withErrors($validator);
                } else {

                        /* Add distortions */
                        $distortions = array();
                        foreach ($input['distortions'] as $row)
                        {
                                if (!empty($row))
                                {
                                        $distortions[] = array(
                                                'cbt_thought_id' => $id,
                                                'distortion_id' => $row,
                                        );
                                }
                        }

                        foreach ($distortions as $data)
                        {
                                $cbt_thought_distortion = new CbtThoughtDistortion($data);
                                $cbt_thought_distortion->cbtThought()->associate($thought);
                                if (!$cbt_thought_distortion->save())
                                {
			                return Redirect::back()->withInput()
                                                ->with('alert-danger', 'Failed to add distortion.');
                                }
                        }

                        /* Add balance thoughts */
                        $balanced_thoughts = array();
                        foreach ($input['balancedthoughts'] as $row_id => $row)
                        {
                                $row = trim($row);
                                if (!empty($row))
                                {
                                        $balanced_thoughts[] = $row;
                                }
                        }

                        /* Update thought */
                        $thought->is_challenged = 1;
                        $thought->balanced_thoughts = serialize($balanced_thoughts);

                        if (!$thought->save())
                        {
		                return Redirect::back()->withInput()
                                        ->with('alert-danger', 'Failed to dispute thought.');
                        }

                        /* Everything ok */
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-success', 'Thought successfully disputed.');
                }
        }
}
