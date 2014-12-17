<?php

class Cbt extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'cbts';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
        protected $hidden = ['user_id', 'created_at', 'updated_at', 'deleted_at'];

	/**
	 * The attributes that can be mass assigned
	 *
	 * @var array
	 */
	protected $fillable = ['date', 'situation'];

	/**
	 * The attributes that cannot be mass assigned
	 *
	 * @var array
	 */
	protected $guarded = ['id', 'user_id', 'created_at', 'updated_at', 'deleted_at'];

	use SoftDeletingTrait;

	/* Model relationships */

	public function cbt_thoughts()
	{
		return $this->hasMany('CbtThought');
	}

	public function cbt_feelings()
	{
		return $this->hasMany('CbtFeeling');
	}

	public function cbt_behaviours()
	{
		return $this->hasMany('CbtBehaviour');
	}

	public static function boot()
	{
		parent::boot();

		/* Hook into save event, setup event bindings */
		Cbt::saving(function($content)
		{
			/* Set user id on save */
			$content->user_id = Auth::id();
		});
	}

	public function scopeCuruser($query)
	{
		return $query->where('user_id', '=', Auth::id());
	}

}
