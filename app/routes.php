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

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::group(array('before' => 'auth'), function() {
        Route::get('/', 'CbtsController@getIndex');
        Route::controller('dashboard', 'DashboardController');
        Route::controller('cbts', 'CbtsController');
        Route::controller('thoughts', 'ThoughtsController');
        Route::controller('statistics', 'StatisticsController');
        Route::controller('feelings', 'FeelingsController');
        Route::controller('symptoms', 'SymptomsController');
        Route::controller('tags', 'TagsController');
        Route::controller('help', 'HelpController');
});

Route::group(['prefix' => 'admin', 'before' => 'admin'], function()
{
	Route::controller('users', 'AdminUsersController');
});

Route::controller('users', 'UsersController');
Route::controller('setup', 'SetupController');
