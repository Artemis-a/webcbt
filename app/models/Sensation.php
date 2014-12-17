<?php

class Sensation extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'sensations';

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
	protected $fillable = ['name'];

	/**
	 * The attributes that cannot be mass assigned
	 *
	 * @var array
	 */
	protected $guarded = ['id', 'user_id', 'created_at', 'updated_at', 'deleted_at'];

	use SoftDeletingTrait;

	public function user()
	{
		return $this->belongsTo('User');
	}

	public static function boot()
	{
		parent::boot();

		/* Hook into save event, setup event bindings */
		Sensation::saving(function($content)
		{
			/* Set user id on save */
			$content->user_id = Auth::id();
		});
	}

	public function scopeCurUser($query)
	{
		return $query->where('user_id', '=', Auth::id());
	}

}
