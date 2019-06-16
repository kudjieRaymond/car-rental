<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarType extends Model
{
	use Uuids, SoftDeletes ;

	public $incrementing =false ;
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'name', 'description', 'created_by', 'modified_by'
	];

	public function cars()
	{
		return $this->hasMany(Car::class);
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'created_by')->withTrashed();
	}

	
}
