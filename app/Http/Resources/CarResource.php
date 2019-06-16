<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
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
				'description' => $this->description,
				'color' =>$this->color,
				'reg_num' =>$this->reg_num,

        'created_at' => (string) $this->created_at,
				'updated_at' => (string) $this->updated_at,
				'created_by' => new UserResource($this->user),
				'car_type' =>new CarTypeResource($this->car_type)
       
      ];
    }
}
