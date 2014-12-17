<?php

class CbtFeeling extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cbt_feelings';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
        protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

	/**
	 * The attributes that can be mass assigned
	 *
	 * @var array
	 */
	protected $fillable = ['feeling_id', 'percent', 'when'];

	/**
	 * The attributes that cannot be mass assigned
	 *
	 * @var array
	 */
	protected $guarded = ['id', 'cbt_id', 'created_at', 'updated_at', 'deleted_at'];

	use SoftDeletingTrait;

	public function cbt()
	{
		return $this->belongsTo('Cbt');
	}

	public function feeling()
	{
		return $this->belongsTo('Feeling');
	}

}
