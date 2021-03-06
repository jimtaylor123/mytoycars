<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Http\Resources\Car as CarResource;
use App\Services\CarsService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Traits\HasImages;

class CarsController extends Controller
{

    use HasImages;

    public function index()
    {
        $this->authorize('viewAny', Car::class);

        return CarResource::collection(request()->user()->cars);
    }

    public function store(Request $request)
    {
        $this->authorize('create', Car::class);
        $car = request()->user()->cars()->create($this->validateData());

        if($request->get('image')) $this->saveImage($request, $car);

        return (new CarResource($car))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Car $car)
    {
        $this->authorize('view', $car);

        return new CarResource($car);
    }

    public function update(Request $request, Car $car)
    {
        $this->authorize('update', $car);

        $car->update($this->validateData());

        if($request->get('image')) $this->saveImage($request, $car);

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
        return request()->validate([
            'name' => 'required',
            'colour' => 'required',
            'value' => 'required'
        ]);
    }
}
