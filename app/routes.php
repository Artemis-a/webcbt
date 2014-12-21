<?php

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

Route::get('/', 'DashboardController@getIndex');

Route::controller('dashboard', 'DashboardController');
Route::controller('cbts', 'CbtsController');
Route::controller('thoughts', 'ThoughtsController');
Route::controller('feelings', 'FeelingsController');
Route::controller('symptoms', 'SymptomsController');
Route::controller('help', 'HelpController');
Route::controller('users', 'UsersController');
