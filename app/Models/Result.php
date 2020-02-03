<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $guarded = [];

    public function race()
    {
        return $this->belongsTo(Race::class);
    }
}
