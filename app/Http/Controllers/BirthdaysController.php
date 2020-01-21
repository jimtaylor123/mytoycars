<?php

namespace App\Http\Controllers;

use App\Http\Resources\Car;
use Illuminate\Http\Request;

class BirthdaysController extends Controller
{
    public function index()
    {
        $cars = request()->user()->cars()->birthdays()->get();

        return Car::collection($cars);
    }
}
