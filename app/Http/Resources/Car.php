<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\User;

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
                'value' => $this->value,
                'photoUrl' =>  $this->photoUrl,
                'last_updated' => $this->updated_at->diffForHumans(),
                'owner' => User::find($this->user_id)->name
            ],
            'links' => [
                'self' => $this->path(),
            ]
        ];
    }
}
