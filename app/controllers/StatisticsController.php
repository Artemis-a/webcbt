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

class StatisticsController extends BaseController {

        public function getIndex()
        {
                /**************************************************************/
                /************************* DISTORTIONS ************************/
                /**************************************************************/

                $distortions = Distortion::orderBy('id', 'ASC')->get();
                $distortions_count['labelset'] = '[';
                $distortions_count['dataset'] = '[';
                foreach ($distortions as $distortion)
                {
                        $result = CbtThoughtDistortion
                                ::where('cbt_thought_distortions.distortion_id', '=', $distortion->id)
                                ->leftJoin('cbt_thoughts', 'cbt_thought_distortions.cbt_thought_id', '=', 'cbt_thoughts.id')
                                ->leftJoin('cbts', 'cbt_thoughts.cbt_id', '=', 'cbts.id')
                                ->where('cbts.user_id', Auth::id())
                                ->get();

                        $distortions_count['labelset'] .= '"' . $distortion->name . '",';
                        $distortions_count['dataset'] .= '"' . $result->count() . '",';
                }
                $distortions_count['labelset'] .= ']';
                $distortions_count['dataset'] .= ']';

                /**************************************************************/
                /************************* PIE CHART **************************/
                /**************************************************************/

                $resolved = Cbt::curuser()
                        ->where('is_resolved', '=', 1)
                        ->get();
                $resolved_count = $resolved->count();

                $unresolved = Cbt::curuser()
                        ->where('is_resolved', '=', 0)
                        ->get();
                $unresolved_count = $unresolved->count();

                $disputed = Cbt::curuser()
                        ->join('cbt_thoughts', 'cbt_thoughts.cbt_id', '=', 'cbts.id')
                        ->where('is_challenged', '=', 1)
                        ->get();
                $disputed_count = $disputed->count();

                $undisputed = Cbt::curuser()
                        ->join('cbt_thoughts', 'cbt_thoughts.cbt_id', '=', 'cbts.id')
                        ->where('is_challenged', '=', 0)
                        ->get();
                $undisputed_count = $undisputed->count();

                /**************************************************************/
                /************************** FEELINGS **************************/
                /**************************************************************/

                $feelings = Feeling::curuser()->orderBy('name', 'ASC')->get();

                /* Feelings before count */
                $feelings_count['labelset'] = '[';
                $feelings_count['before']['dataset'] = '[';
                $feelings_before_rows = array();
                foreach ($feelings as $feeling)
                {
                        $result = CbtFeeling
                                ::where('cbt_feelings.feeling_id', '=', $feeling->id)
                                ->where('cbt_feelings.status', '=', 'B')
                                ->get();
                        $feelings_count['labelset'] .= '"' . $feeling->name  . '",';
                        $feelings_count['before']['dataset'] .= '"' . $result->count()  . '",';
                        $feelings_before_rows[$feeling->id] = $result->count();
                }
                $feelings_count['labelset'] .= ']';
                $feelings_count['before']['dataset'] .= ']';

                /* Feelings after count */
                $feelings_count['after']['dataset'] = '[';
                $feelings_after_rows = array();
                foreach ($feelings as $feeling)
                {
                        $result = CbtFeeling
                                ::where('cbt_feelings.feeling_id', '=', $feeling->id)
                                ->where('cbt_feelings.status', '=', 'A')
                                ->get();
                        $feelings_count['after']['dataset'] .= '"' . $result->count()  . '",';
                        $feelings_after_rows[$feeling->id] = $result->count();
                }
                $feelings_count['after']['dataset'] .= ']';

                /* Feelings before average */
                $feelings_average['labelset'] = '[';
                $feelings_average['before']['dataset'] = '[';
                foreach ($feelings as $feeling)
                {
                        $result = CbtFeeling
                                ::where('cbt_feelings.feeling_id', '=', $feeling->id)
                                ->where('cbt_feelings.status', '=', 'B')
                                ->sum('intensity');

                        $feelings_average['labelset'] .= '"' . $feeling->name  . '",';

                        if ($feelings_before_rows[$feeling->id] <= 0) {
                                $average_value = 0;
                        } else {
                                $average_value = (int)($result / $feelings_before_rows[$feeling->id]);
                        }

                        $feelings_average['before']['dataset'] .= '"' . $average_value  . '",';
                }
                $feelings_average['labelset'] .= ']';
                $feelings_average['before']['dataset'] .= ']';

                /* Feelings after average */
                $feelings_average['after']['dataset'] = '[';
                foreach ($feelings as $feeling)
                {
                        $result = CbtFeeling
                                ::where('cbt_feelings.feeling_id', '=', $feeling->id)
                                ->where('cbt_feelings.status', '=', 'A')
                                ->sum('intensity');

                        if ($feelings_after_rows[$feeling->id] <= 0) {
                                $average_value = 0;
                        } else {
                                $average_value = (int)($result / $feelings_after_rows[$feeling->id]);
                        }

                        $feelings_average['after']['dataset'] .= '"' . $average_value  . '",';
                }
                $feelings_average['after']['dataset'] .= ']';

                /**************************************************************/
                /************************** SYMPTOMS **************************/
                /**************************************************************/

                $symptoms = Symptom::curuser()->orderBy('name', 'ASC')->get();

                /* Symptoms before count */
                $symptoms_count['labelset'] = '[';
                $symptoms_count['before']['dataset'] = '[';
                $symptoms_before_rows = array();
                foreach ($symptoms as $symptom)
                {
                        $result = CbtSymptom
                                ::where('cbt_symptoms.symptom_id', '=', $symptom->id)
                                ->where('cbt_symptoms.status', '=', 'B')
                                ->get();
                        $symptoms_count['labelset'] .= '"' . $symptom->name  . '",';
                        $symptoms_count['before']['dataset'] .= '"' . $result->count()  . '",';
                        $symptoms_before_rows[$symptom->id] = $result->count();
                }
                $symptoms_count['labelset'] .= ']';
                $symptoms_count['before']['dataset'] .= ']';

                /* Symptoms after count */
                $symptoms_count['after']['dataset'] = '[';
                $symptoms_after_rows = array();
                foreach ($symptoms as $symptom)
                {
                        $result = CbtSymptom
                                ::where('cbt_symptoms.symptom_id', '=', $symptom->id)
                                ->where('cbt_symptoms.status', '=', 'A')
                                ->get();
                        $symptoms_count['after']['dataset'] .= '"' . $result->count()  . '",';
                        $symptoms_after_rows[$symptom->id] = $result->count();
                }
                $symptoms_count['after']['dataset'] .= ']';

                /* Symptoms before average */
                $symptoms_average['labelset'] = '[';
                $symptoms_average['before']['dataset'] = '[';
                foreach ($symptoms as $symptom)
                {
                        $result = CbtSymptom
                                ::where('cbt_symptoms.symptom_id', '=', $symptom->id)
                                ->where('cbt_symptoms.status', '=', 'B')
                                ->sum('intensity');
                        $symptoms_average['labelset'] .= '"' . $symptom->name  . '",';

                        if ($symptoms_before_rows[$symptom->id] <= 0) {
                                $average_value = 0;
                        } else {
                                $average_value = (int)($result / $symptoms_before_rows[$symptom->id]);
                        }

                        $symptoms_average['before']['dataset'] .= '"' . $average_value  . '",';
                }
                $symptoms_average['labelset'] .= ']';
                $symptoms_average['before']['dataset'] .= ']';

                /* Symptoms after average */
                $symptoms_average['after']['dataset'] = '[';
                foreach ($symptoms as $symptom)
                {
                        $result = CbtSymptom
                                ::where('cbt_symptoms.symptom_id', '=', $symptom->id)
                                ->where('cbt_symptoms.status', '=', 'A')
                                ->sum('intensity');

                        if ($symptoms_after_rows[$symptom->id] <= 0) {
                                $average_value = 0;
                        } else {
                                $average_value = (int)($result / $symptoms_after_rows[$symptom->id]);
                        }

                        $symptoms_average['after']['dataset'] .= '"' . $average_value  . '",';
                }
                $symptoms_average['after']['dataset'] .= ']';

                return View::make('statistics.index')
                        ->with('distortions_count', $distortions_count)
                        ->with('resolved_count', $resolved_count)
                        ->with('unresolved_count', $unresolved_count)
                        ->with('disputed_count', $disputed_count)
                        ->with('undisputed_count', $undisputed_count)
                        ->with('feelings_count', $feelings_count)
                        ->with('feelings_average', $feelings_average)
                        ->with('symptoms_count', $symptoms_count)
                        ->with('symptoms_average', $symptoms_average)
                        ;
        }
}
