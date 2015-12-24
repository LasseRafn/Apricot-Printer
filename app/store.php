<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Store extends Model
{
	use SoftDeletes;


	const STATE_PENDING = 'pending';
	const STATE_COMPLETED = 'completed';
	const STATE_FAILED = 'failed';

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'stores';

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [ 'identifier', 'domain', 'type_id', 'account_id', 'auth_token', 'auth_state' ];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = [];

	public function getId()
	{
		return $this->id;
	}

	public function getDomain()
	{
		return $this->domain;
	}
}
