<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class FilesController extends Controller
{
    public function store(Request $request)
    {
        if($request->get('image'))
        {
           $image = $request->get('image');
           $name = time().'.' . explode('/', explode(':', substr($image, 0, strpos($image, ';')))[1])[1];

           if (!file_exists(public_path('images/'))) {
                mkdir(public_path('images/'), 666, true);
            }
           \Image::make($request->get('image'))->save(storage_path('images/').$name);
         }
dd($name);
        $image= new FileUpload();
        $image->image_name = $name;
        $image->save();


        return response()->json(['success' => 'You have successfully uploaded an image'], 200);
    }
}
