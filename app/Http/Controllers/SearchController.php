<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Resources\Car as CarResource;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index()
    {
        $data = request()->validate([
            'searchTerm' => 'required',
        ]);

        $cars = Car::search($data['searchTerm'])
            ->where('user_id', request()->user()->id)
            ->get();

        return CarResource::collection($cars);
    }
}
