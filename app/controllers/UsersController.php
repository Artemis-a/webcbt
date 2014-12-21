<?php

class UsersController extends BaseController {

	public function getLogin()
	{

	}

	public function getLogout()
	{

	}

	public function getRegister()
	{

	}

	public function getForgot()
	{

	}

	public function getVerify()
	{

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

	public function getSettings()
	{
		return View::make('users.settings');
	}

}
