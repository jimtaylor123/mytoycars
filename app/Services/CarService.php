<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Car;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class CarService
{
    public static function saveImage(Request $request, Car $car)
    {
        $image = $request->get('image');
        $type = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        $name = 'cars/' . $car->id . '-' . time().'.' . $type;
        $file = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $image));
        Storage::disk('s3')->put($name, $file, 'public');
        $car->photoUrl = $name;
        $car->save();
    }
}


