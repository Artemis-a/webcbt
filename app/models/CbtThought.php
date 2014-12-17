<?php

class CbtThought extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cbt_thoughts';

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
	protected $fillable = ['thought', 'is_challenged', 'dispute',
		'balanced_thoughts'];

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

}
