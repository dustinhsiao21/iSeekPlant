<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['namespace' => 'API', 'as' => 'api::'], function () {
    Route::get('/cities', 'WeatherController@getCities')->name('city_lists');
    Route::get('/forecast', 'WeatherController@getForecast')->name('five_days_forecast');
});
