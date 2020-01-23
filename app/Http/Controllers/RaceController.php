<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Car;

class RaceController extends Controller
{
    public function index()
    {
        dd(request(), 'HI');
        $cars = request()->user()->cars()->races()->get();

        return Car::collection($cars);
    }
}
