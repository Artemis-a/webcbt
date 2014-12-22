<?php

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
			->with('alert-warning', 'Login failed.');
	}

	public function getLogout()
	{
		Auth::logout();
		Session::flush();

		return Redirect::action('UsersController@getLogin')
                        ->with('alert-warning', 'User logged out.');
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
					->with('alert-danger', 'User verification successful. Please login below.');
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

		return View::make('users.profile')->with('user', $user);
	}

	public function getEditprofile()
	{
		$user = Auth::user();

		return View::make('users.editprofile')->with('user', $user);
	}

	public function postEditprofile()
	{
		$user = Auth::user();

                $input = Input::all();

                $temp1 = date_create_from_format('Y-m-d', $input['dob']);
		if (!$temp1)
		{
	                return Redirect::back()->withInput()
                                ->with('alert-danger', 'Invalid date of birth.');
		}
                $input['dob'] = date_format($temp1, 'Y-m-d');

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
			$user->dob = $input['dob'];
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
                                ->with('alert-success', 'Invalid user.');
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
