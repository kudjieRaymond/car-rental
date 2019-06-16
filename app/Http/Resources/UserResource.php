<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
			return [
        'id' => $this->id,
        'name' => $this->name,
				'email' => $this->email,
				'address' =>$this->address,
				'phone_number' =>$this->phone_number,
				'avatar' =>$this->avatar,
        'created_at' => (string) $this->created_at,
				'updated_at' => (string) $this->updated_at,
       
      ];
    }
}
