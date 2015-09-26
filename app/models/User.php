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

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

class User extends Eloquent implements UserInterface {

	/* use SoftDeletingTrait; */

	use UserTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('remember_token');

	/**
	 * The attributes that can be mass assigned
	 *
	 * @var array
	 */
	protected $fillable = array('username', 'password', 'fullname', 'email', 'gender', 'dob', 'timezone',
		'dateformat_php', 'dateformat_cal', 'dateformat_js');

	/**
	 * The attributes that cannot be mass assigned
	 *
	 * @var array
	 */
	protected $guarded = array('id', 'is_admin', 'admin_verified', 'email_verified', 'status');

	/**
	 * Disable remember token
	 * http://laravel.io/forum/05-21-2014-how-to-disable-remember-token
	 */

	public function getRememberToken()
	{
		return null; // not supported
	}

	public function setRememberToken($value)
	{
		// not supported
	}

	public function getRememberTokenName()
	{
		return null; // not supported
	}

	/**
	* Overrides the method to ignore the remember token.
	*/
	public function setAttribute($key, $value)
	{
		$isRememberTokenAttribute = $key == $this->getRememberTokenName();
		if (!$isRememberTokenAttribute)
		{
			parent::setAttribute($key, $value);
		}
	}

	/**
	 * This function initializes data for each user
	 */
	public static function initDB($user_id)
	{
		$feelings_data = array(
			/* Positive feelings */
			array('name' => 'Calm', 'type' => '1'),
			array('name' => 'Confident', 'type' => '1'),
			array('name' => 'Content', 'type' => '1'),
			array('name' => 'Delighted', 'type' => '1'),
			array('name' => 'Encouraged', 'type' => '1'),
			array('name' => 'Energetic', 'type' => '1'),
			array('name' => 'Excited', 'type' => '1'),
			array('name' => 'Happy', 'type' => '1'),
			array('name' => 'Important', 'type' => '1'),
			array('name' => 'Loved', 'type' => '1'),
			array('name' => 'Peaceful', 'type' => '1'),
			array('name' => 'Pleased', 'type' => '1'),
			array('name' => 'Relaxed', 'type' => '1'),
			array('name' => 'Secure', 'type' => '1'),
			array('name' => 'Special', 'type' => '1'),
			array('name' => 'Strong', 'type' => '1'),

			/* Negative feelings */
			array('name' => 'Afraid', 'type' => '2'),
			array('name' => 'Alone', 'type' => '2'),
			array('name' => 'Angry', 'type' => '2'),
			array('name' => 'Ashamed', 'type' => '2'),
			array('name' => 'Bored', 'type' => '2'),
			array('name' => 'Confused', 'type' => '2'),
			array('name' => 'Disappointed', 'type' => '2'),
			array('name' => 'Empty', 'type' => '2'),
			array('name' => 'Frustrated', 'type' => '2'),
			array('name' => 'Guilty', 'type' => '2'),
			array('name' => 'Hurt', 'type' => '2'),
			array('name' => 'Lonely', 'type' => '2'),
			array('name' => 'Nervous', 'type' => '2'),
			array('name' => 'Powerless', 'type' => '2'),
			array('name' => 'Restless', 'type' => '2'),
			array('name' => 'Sad', 'type' => '2'),
			array('name' => 'Tensed', 'type' => '2'),
			array('name' => 'Tired', 'type' => '2'),
			array('name' => 'Trapped', 'type' => '2'),
		);

		$symptoms_data = array(
			/* Negative symptoms */
			array('name' => 'Chest pain or discomfort', 'type' => '2'),
			array('name' => 'Chills or hot flashes', 'type' => '2'),
			array('name' => 'Dizzy', 'type' => '2'),
			array('name' => 'Fear of dying', 'type' => '2'),
			array('name' => 'Feeling of choking', 'type' => '2'),
			array('name' => 'Heart Palpitation', 'type' => '2'),
			array('name' => 'Losing control/going crazy', 'type' => '2'),
			array('name' => 'Nausea', 'type' => '2'),
			array('name' => 'Numbness', 'type' => '2'),
			array('name' => 'Shortness of breath', 'type' => '2'),
			array('name' => 'Stomach cramps', 'type' => '2'),
			array('name' => 'Sweating', 'type' => '2'),
			array('name' => 'Tingling sensation', 'type' => '2'),
			array('name' => 'Trembling', 'type' => '2'),
		);

		foreach ($feelings_data as $feeling)
		{
			DB::insert('INSERT INTO feelings (user_id, name, type) values (?, ?, ?)',
				array($user_id, $feeling['name'], $feeling['type']));
		}

		foreach ($symptoms_data as $symptom)
		{
			DB::insert('INSERT INTO symptoms (user_id, name, type) values (?, ?, ?)',
				array($user_id, $symptom['name'], $symptom['type']));
		}
	}
}
