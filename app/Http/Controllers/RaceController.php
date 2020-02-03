<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Race as RaceResource;
use App\Models\Race;
use Carbon\Carbon;

class RaceController extends Controller
{
    public function index($time)
    {
        $now = Carbon::now();

        switch($time){
            case 'past':
            $races = RaceResource::collection(Race::where('date', '<=', $now->toDateTimeString())->get());
            break;

            case 'upcoming':
            $races = RaceResource::collection(Race::where('date', '>', $now->toDateTimeString())->get());
            break;

            default:
            $races = RaceResource::collection(Race::all());
        }


        return $races;
    }

    public function store()
    {
        $this->authorize('create', Race::class);
        $race = (new Race())->create($this->validateData());

        return (new RaceResource($race))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }
}
