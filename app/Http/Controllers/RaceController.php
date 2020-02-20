<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\Race as RaceResource;
use App\Models\Race;
use App\Http\Requests\RaceRequest;
use Symfony\Component\HttpFoundation\Response;
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

    public function show(Race $race)
    {
        $this->authorize('view', $race);

        return new RaceResource($race);
    }

    public function store(RaceRequest $request)
    {


        $race = (new Race());
        $race->name = $request->name;
        $race->prize = $request->prize;
        $race->date = $request->date;
        $race->location = $request->location["city"];
        $race->lat = $request->location["latitude"];
        $race->lng = $request->location["longitude"];
        $race->save();

        return (new RaceResource($race))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function update(RaceRequest $request, Race $race)
    {
        $this->authorize('update', $race);

        $race->update($race->toArray());
        $race->location = $request->location["city"];
        $race->lat = $request->location["latitude"];
        $race->lng = $request->location["longitude"];
        $race->save();

        return (new RaceResource($race))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }
}
