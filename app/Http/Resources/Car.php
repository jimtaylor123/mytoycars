<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Car extends JsonResource
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
            'data' => [
                'car_id' => $this->id,
                'user_id' => $this->user_id,
                'name' => $this->name,
                'colour' => $this->colour,
                'birthday' => $this->birthday->format('m/d/Y'),
                'photoUrl' =>  $this->photoUrl,
                'last_updated' => $this->updated_at->diffForHumans(),
            ],
            'links' => [
                'self' => $this->path(),
            ]
        ];
    }
}
