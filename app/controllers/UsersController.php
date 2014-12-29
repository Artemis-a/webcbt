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

class UsersController extends BaseController {

	public function getLogin()
	{
		return View::make('users.login');
	}

	public function postLogin()
	{
		$input = Input::all();

		$login_data = array(
			'username' => $input['username'],
			'password' => $input['password'],
			'status' => 1
		);

		if (Auth::attempt($login_data))
		{
			return Redirect::intended('dashboard');
		}

		return Redirect::action('UsersController@getLogin')
			->with('alert-danger', 'Login failed.');
	}

	public function getLogout()
	{
		Auth::logout();
		Session::flush();

		return Redirect::action('UsersController@getLogin')
                        ->with('alert-success', 'User logged out.');
	}

	public function getRegister()
	{
		return View::make('users.register');
	}

	public function postRegister()
	{
                $input = Input::all();

                $rules = array(
                        'username' => 'required|unique:users,username',
			'email' => 'required|email|unique:users,email',
			'password' => 'required|min:3',
                );

                $validator = Validator::make($input, $rules);

                if ($validator->fails())
                {
                        return Redirect::back()->withInput()->withErrors($validator);
                } else {

                        /* Create a symptom */
                        $user_data = array(
                                'username' => $input['username'],
				'password' => Hash::make($input['password']),
				'email' => $input['email'],
				'status' => 1,
				'verification_key' =>
					substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyz"), 0, 20),
				'email_verified' => 1,
				'admin_verified' => 1,
				'retry_count' => 0,
                        );
                        $user = User::create($user_data);
			if (!$user)
			{
			        return Redirect::back()->withInput()
                                        ->with('alert-danger', 'Failed to create user.');
			}

                        /* Everything ok */
                        return Redirect::action('UsersController@getLogin')
                                ->with('alert-success', 'User created. Please login below.');
                }
	}

	public function getForgot()
	{
		return View::make('users.forgot');
	}

	public function postForgot()
	{
		$input = Input::all();

		if (!empty($input['userinput']))
		{
			$user = User::where('username', '=', $input['userinput'])->first();
			if ($user)
			{
				/* TODO : Send email to reset password */
				return Redirect::action('UsersController@getLogin')
					->with('alert-success', 'Password resetted. Please check your email.');
			}

			$user = User::where('email', '=', $input['userinput'])->first();
			if ($user)
			{
				/* TODO : Send email to reset password */
				return Redirect::action('UsersController@getLogin')
					->with('alert-success', 'Password resetted. Please check your email.');
			}

			return Redirect::back()->withInput()
                                ->with('alert-danger', 'User does not exists.');
		}
		return View::make('users.forgot');
	}

	public function getVerify($username, $key = '')
	{
		if (empty($key))
		{
			return Redirect::to('users/login')
				->with('alert-danger', 'User verification failed.');
		}

		$user = User::where('username', '=', $username)
			->where('verification_key', '=', $key)->first();

		if ($user)
		{
			$user->email_verified = 1;
			$user->verification_key = '';

			if ($user->save())
			{
				return Redirect::to('users/login')
					->with('alert-success', 'User verification successful. Please login below.');
			} else {
				return Redirect::to('users/login')
					->with('alert-danger', 'User verification failed.');
			}

		} else {
		        return Redirect::to('users/login')
                                ->with('alert-danger', 'User verification failed.');
		}
	}

	public function getProfile()
	{
		$user = Auth::user();

		$timezone_options = timezone_list();

		$dob = '';
                $temp = date_create_from_format(
			'Y-m-d', $user->dob
		);
		if ($temp)
		{
			$dob = date_format(
				$temp, explode('|', $user->dateformat)[0]
			);
		}

		return View::make('users.profile')
			->with('dob', $dob)
			->with('timezone_options', $timezone_options)
			->with('user', $user);
	}

	public function getEditprofile()
	{
		$user = Auth::user();

		$timezone_options = array('' => 'Please select...') + timezone_list();

		$gender_options = array(
			'' => 'Please select...',
			'M' => 'Male',
			'F' => 'Female',
			'U' => 'Undisclosed',
		);

		$dateformat_options = array(
	                '' => 'Please select...',
	                'd-M-Y|dd-M-yy' => 'Day-Month-Year',
	                'M-d-Y|M-dd-yy' => 'Month-Day-Year',
	                'Y-M-d|yy-M-dd' => 'Year-Month-Day',
		);

		$dob = '';
                $temp = date_create_from_format(
			'Y-m-d', $user->dob
		);
		if ($temp)
		{
			$dob = date_format(
				$temp, explode('|', $user->dateformat)[0]
			);
		}

		return View::make('users.editprofile')
			->with('dob', $dob)
			->with('timezone_options', $timezone_options)
			->with('gender_options', $gender_options)
			->with('dateformat_options', $dateformat_options)
			->with('user', $user);
	}

	public function postEditprofile()
	{
		$user = Auth::user();

                $input = Input::all();

		$php_dateformat = explode('|', $input['dateformat'])[0];
                $temp = date_create_from_format($php_dateformat, $input['dob']);
		if (!$temp)
		{
	                return Redirect::back()->withInput()
                                ->with('alert-danger', 'Invalid date of birth.');
		}

                $rules = array(
			'fullname' => 'required',
			'email' => 'required|email|unique:users,email,'.Auth::user()->id,
			'dob' => 'required|date',
			'gender' => 'required|in:M,F,U',
			'dateformat' => 'required',
			'timezone' => 'required',
                );

                $validator = Validator::make($input, $rules);

                if ($validator->fails())
                {
                        return Redirect::back()->withInput()->withErrors($validator);
                } else {

                        /* Update user */
                        $user->fullname = $input['fullname'];
                        $user->email = $input['email'];
			$user->dob = date_format($temp, 'Y-m-d');
                        $user->gender = $input['gender'];
			$user->dateformat = $input['dateformat'];
			$user->timezone = $input['timezone'];

                        if (!$user->save())
                        {
		                return Redirect::back()->withInput()
                                        ->with('alert-danger', 'Failed to update profile.');
                        }

                        /* Everything ok */
                        return Redirect::action('UsersController@getProfile')
                                ->with('alert-success', 'Profile updated.');

		}
	}

	public function getChangepass()
	{
		return View::make('users.changepass');
	}

	public function postChangepass()
	{
                $input = Input::all();

		$user = User::where('id', '=', Auth::user()->id)->first();

		if (!$user)
		{
                        return Redirect::action('UsersController@getProfile')
                                ->with('alert-danger', 'Invalid user.');
		}

		if (!Hash::check($input['oldpassword'], $user->password))
		{
	                return Redirect::back()->withInput()
                                ->with('alert-danger', 'Old password does not match.');
		}

		$user->password = Hash::make($input['newpassword']);

                if (!$user->save())
                {
	                return Redirect::back()->withInput()
                                ->with('alert-danger', 'Failed to update password.');
                }

                /* Everything ok */
                return Redirect::action('UsersController@getProfile')
                        ->with('alert-success', 'Password updated.');
	}
}
