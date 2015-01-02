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

class ThoughtsController extends BaseController {

        public function getDispute($id)
        {
		$thought = CbtThought::find($id);
                if (!$thought)
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Thought not found.');
                }

                if ($thought->cbt['user_id'] != Auth::id())
                {
                        return Redirect::action('CbtsController@getIndex')
                                ->with('alert-danger', 'Invalid access.');
                }

                $distortions_list = array(0 => 'Please select...') +
                        Distortion::orderBy('id', 'ASC')->lists('name', 'id');

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
                                ->with('alert-danger', 'Thought not found.');
                }

                if ($thought->cbt['user_id'] != Auth::id())
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

                        /* Delete old and then add distortions */
                        CbtThoughtDistortion::where('cbt_thought_id', '=', $id)->delete();

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

                        /********* Disputes *********/
                        $disputes = array();
                        foreach ($input['forevidence'] as $row_id => $row)
                        {
                                $row = trim($row);
                                if (!empty($row))
                                {
                                        $disputes['forevidence'][] = $row;
                                }
                        }
                        foreach ($input['againstevidence'] as $row_id => $row)
                        {
                                $row = trim($row);
                                if (!empty($row))
                                {
                                        $disputes['againstevidence'][] = $row;
                                }
                        }
                        foreach ($input['experiment'] as $row_id => $row)
                        {
                                $row = trim($row);
                                if (!empty($row))
                                {
                                        $disputes['experiment'][] = $row;
                                }
                        }
                        if (!empty($input['experimentresult']))
                        {
                                $disputes['experimentresult'] = trim($input['experimentresult']);
                        }
                        if (!empty($input['doublestandard']))
                        {
                                $disputes['doublestandard'] = trim($input['doublestandard']);
                        }
                        foreach ($input['survey'] as $row_id => $row)
                        {
                                $row = trim($row);
                                if (!empty($row))
                                {
                                        $disputes['survey'][] = $row;
                                }
                        }
                        if (!empty($input['surveyresult']))
                        {
                                $disputes['surveyresult'] = trim($input['surveyresult']);
                        }
                        foreach ($input['label'] as $row_id => $row)
                        {
                                $row = trim($row);
                                if (!empty($row))
                                {
                                        $disputes['label'][] = $row;
                                }
                        }
                        foreach ($input['meaning'] as $row_id => $row)
                        {
                                $row = trim($row);
                                if (!empty($row))
                                {
                                        $disputes['meaning'][] = $row;
                                }
                        }
                        foreach ($input['advantage'] as $row_id => $row)
                        {
                                $row = trim($row);
                                if (!empty($row))
                                {
                                        $disputes['advantage'][] = $row;
                                }
                        }
                        foreach ($input['disadvantage'] as $row_id => $row)
                        {
                                $row = trim($row);
                                if (!empty($row))
                                {
                                        $disputes['disadvantage'][] = $row;
                                }
                        }
                        foreach ($input['iftrue'] as $row_id => $row)
                        {
                                $row = trim($row);
                                if (!empty($row))
                                {
                                        $disputes['iftrue'][] = $row;
                                }
                        }
                        foreach ($input['reattribution'] as $row_id => $row)
                        {
                                $row = trim($row);
                                if (!empty($row))
                                {
                                        $disputes['reattribution'][] = $row;
                                }
                        }
                        foreach ($input['reframe'] as $row_id => $row)
                        {
                                $row = trim($row);
                                if (!empty($row))
                                {
                                        $disputes['reframe'][] = $row;
                                }
                        }
                        foreach ($input['rationalize'] as $row_id => $row)
                        {
                                $row = trim($row);
                                if (!empty($row))
                                {
                                        $disputes['rationalize'][] = $row;
                                }
                        }

                        /* Update thought */
                        $thought->is_challenged = 1;
                        $thought->dispute = serialize($disputes);
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
