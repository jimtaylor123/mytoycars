<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Car extends Model
{
    use Searchable;

    protected $guarded = [];

    protected $casts = [
        'value' => 'decimal:2',
    ];

    public function path()
    {
        return '/cars/' . $this->id;
    }

    public function setValueAttribute($value)
    {
        $this->attributes['value'] = number_format((float)$value, 2, '.', '');
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function results()
    {
        return $this->hasMany(Result::class);
    }
}
