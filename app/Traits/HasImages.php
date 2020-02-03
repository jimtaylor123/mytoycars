<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Car;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

trait HasImages
{
    /**
     * Type hint model as eloquent model?
     *
     * @param Request $request
     * @param [type] $model
     * @return void
     */
    public static function saveImage(Request $request, $model)
    {
        $image = $request->get('image');
        $type = explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];
        $name = 'models/' . $model->id . '-' . time().'.' . $type;
        $file = base64_decode(preg_replace('/^data:image\/\w+;base64,/', '', $image));
        Storage::disk('s3')->put($name, $file, 'public');
        $model->photoUrl = $name;
        $model->save();
    }
}


