<?php

use Illuminate\Http\Request;

/**
     * Cities
     */
Route::get('city/search', 'CityController@search');

Route::middleware('auth:api')->group(function () {

    /**
     * Cars
     */
    Route::get('cars', 'CarsController@index');
    Route::post('cars', 'CarsController@store');
    Route::get('cars/{car}', 'CarsController@show');
    Route::patch('cars/{car}', 'CarsController@update');
    Route::delete('cars/{car}', 'CarsController@destroy');

    /**
     * Races
     */
    Route::get('races/{time}', 'RaceController@index')->where('time', '[A-Za-z]+');
    Route::get('races/{race}', 'RaceController@show')->where('car', '[0-9]+');
    Route::post('races', 'RaceController@store');
    Route::patch('races/{race}', 'RaceController@update');

     /**
     * Race Results
     */
    Route::get('/results', 'ResultsController@index');

    /**
     * Search
     */
    Route::post('search', 'SearchController@index');


});
