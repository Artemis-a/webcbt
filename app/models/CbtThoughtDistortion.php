<?php

class CbtThoughtDistortion extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cbt_thought_distortions';

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
	protected $fillable = ['cbt_thought_id', 'distortion_id'];

	/**
	 * The attributes that cannot be mass assigned
	 *
	 * @var array
	 */
	protected $guarded = ['id'];

	public $timestamps = false;

	public function cbtThought()
	{
		return $this->belongsTo('CbtThought');
	}

	public function distortion()
	{
		return $this->belongsTo('Distortion');
	}
}
