<?php

    /*
    |--------------------------------------------------------------------------
    | Third Party Weather Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party weather services.
    |
    */
return [
    'weatherbit' => [
        'base_url' => 'https://api.weatherbit.io/v2.0/',
        'key' => env('WEATHERBIT_KEY'),
    ],
];
