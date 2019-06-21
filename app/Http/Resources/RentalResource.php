<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RentalResource extends JsonResource
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
				'start_date' => (string) $this->start_date,
				'end_date' => (string) $this->end_date,
				'code' =>  $this->code,
				'cars'=> CarResource::collection($this->cars),
				'client' => new UserResource($this->client),
				'created_by'=> new UserResource($this->user),
			 ];
    }
}
