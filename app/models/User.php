<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;

class User extends Eloquent implements UserInterface {

	use SoftDeletingTrait, UserTrait;

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
	protected $hidden = array();

	/**
	 * The attributes that can be mass assigned
	 *
	 * @var array
	 */
	protected $fillable = ['username', 'password', 'fullname', 'email',
		'gender', 'dob', 'dateformat', 'timezone', 'status'];

	/**
	 * The attributes that cannot be mass assigned
	 *
	 * @var array
	 */
	protected $guarded = ['id', 'status', 'created_at', 'updated_at', 'deleted_at'];

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
}
