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

class DashboardController extends BaseController {

        public function getIndex()
        {
                $user = User::find(Auth::id());

                $exercise_count = Cbt::curuser()->count();

                $unresolved_count = Cbt::curuser()
                        ->where('is_resolved', 0)
                        ->count();

                $undisputed_count =
                        CbtThought::where('cbt_thoughts.is_disputed', 0)
                        ->where('cbts.user_id', '=', Auth::id())
                        ->leftJoin('cbts', 'cbt_thoughts.cbt_id', '=', 'cbts.id')
                        ->count();

                $user_date = date_create_from_format('Y-m-d H:i:s', Auth::user()->created_at);
                $todays_date = date_create('now');
                $diff = date_diff($todays_date, $user_date);
                $diff_days = $diff->format('%a');

                return View::make('dashboard.index')
                        ->with('exercise_count', $exercise_count)
                        ->with('unresolved_count', $unresolved_count)
                        ->with('undisputed_count', $undisputed_count)
                        ->with('diff_days', $diff_days)
                        ->with('dateformat', $user->dateformat);
        }

}
