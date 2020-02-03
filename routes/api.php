<?php

use Illuminate\Http\Request;

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
    Route::get('races/{time}', 'RaceController@index');
    Route::post('races', 'RaceController@store');

     /**
     * Race Results
     */
    Route::get('/results', 'ResultsController@index');

    /**
     * Search
     */
    Route::post('search', 'SearchController@index');
});
