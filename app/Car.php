<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
	use Uuids, SoftDeletes ;
	
	public $incrementing =false ;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
			'name', 'description','color', 'reg_num', 'car_type_id', 'created_by', 'modified_by'
	];

	public function car_type()
	{
		return $this->belongsTo(CarType::class)->withTrashed();
	}

	public function user()
	{
		return $this->belongsTo(User::class,'created_by')->withTrashed();
	}

	/** 
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function rentals()
	{
		return $this->belongsToMany(User::class, 'rentals', 'car_id', 'user_id')
								->withPivot('start_date', 'end_date', 'returned','created_by', 'modified_by')
								->withTimestamps();
	}

}
