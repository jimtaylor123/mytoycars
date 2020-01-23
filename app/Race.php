<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Race extends Model
{
    protected $guarded = [];

    public function scopeUpcoming($query)
    {
        return $query->whereRaw('date > ' . now()->toDateString());
    }

    public function cars()
    {
        return $this->hasMany(Car::class);
    }

    public function results()
    {
        return $this->hasMany(Results::class);
    }
}