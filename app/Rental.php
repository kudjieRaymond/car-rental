<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rental extends Model
{
	use Uuids, SoftDeletes ;

	public $incrementing =false ;

	public function user()
	{
		return $this->belongsTo(User::class,'created_by')->withTrashed();
	}


	public function client()
	{
		return $this->belongsTo(User::class,'client_id')->withTrashed();
	}

	protected $dates =['start_date', 'end_date'];

}
