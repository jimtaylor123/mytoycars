<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Race extends JsonResource
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
                'race_id'  => $this->id,
                'name'     => $this->name,
                'date'     => $this->date,
                'prize'    => $this->prize,
                'location' => $this->location,
                'lat'      => $this->lat,
                'lng'      => $this->lng
            ],
            'links' => [
                'self' => $this->path(),
            ]
        ];
    }
}
