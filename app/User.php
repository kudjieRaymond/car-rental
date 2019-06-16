<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Uuids;
use Hash;
class User extends Authenticatable implements JWTSubject
{
		use Notifiable, Uuids, SoftDeletes ;
		
		public $incrementing =false ;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','address', 'access','avatar', 'phone_number'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
		];
		
		 /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
		}
		
		/**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
		}
		
		 /**
     * Hash password
     * @param $input
     */
    public function setPasswordAttribute($input)
    {
      if ($input)
					$this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
    }
		
		public function cars()
		{
			return $this->hasMany(Car::class);
		}

			public function car_types()
		{
			return $this->hasMany(CarType::class);
		}

			/** 
	 * 
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function rentals()
	{
		return $this->belongsToMany(Car::class, 'rentals', 'user_id', 'car_id')
								->withPivot('start_date', 'end_date', 'returned','created_by', 'modified_by')
								->withTimestamps();
	}

}
