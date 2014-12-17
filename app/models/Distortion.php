<?php

class Distortion extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'distortions';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
        protected $hidden = [];

	/**
	 * The attributes that can be mass assigned
	 *
	 * @var array
	 */
	protected $fillable = ['name'];

	/**
	 * The attributes that cannot be mass assigned
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

}
