<?php

namespace App\Http\Controllers;

use App\Car;
use App\Http\Resources\Car as CarResource;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CarsController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Car::class);

        return CarResource::collection(request()->user()->cars);
    }

    public function store()
    {
        // dd(request());
        $this->authorize('create', Car::class);

        $car = request()->user()->cars()->create($this->validateData());

        return (new CarResource($car))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Car $car)
    {
        $this->authorize('view', $car);

        return new CarResource($car);
    }

    public function update(Car $car)
    {
        $this->authorize('update', $car);

        $car->update($this->validateData());

        return (new CarResource($car))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    public function destroy(Car $car)
    {
        $this->authorize('delete', $car);

        $car->delete();

        return response([], Response::HTTP_NO_CONTENT);
    }

    private function validateData()
    {
        // return request()->except('api_token');
        return request()->validate([
            'name' => 'required',
            'colour' => 'required',
            'birthday' => 'required',
            'photoUrl' => 'required'
        ]);
    }
}
