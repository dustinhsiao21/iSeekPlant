<?php

namespace App\Http\Controllers\API;

use App\Contracts\WeatherService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForecastRequest;

class WeatherController extends Controller
{
    /**
     * Weather Service.
     *
     * @var WeatherService
     */
    private $weatherService;

    /**
     * Create a new controller instance.
     *
     * @param WeatherService $weatherService
     * @return void
     */
    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    /**
     * Get City List.
     *
     * @return array
     */
    public function getCities() : array
    {
        $data = $this->weatherService->getCityList();

        return array_map(function ($city) {
            return [
                'id' => $city['id'],
                'city_name' => $city['city_name'],
            ];
        }, $data);
    }

    /**
     * Get 5-days forecast.
     *
     * @param ForecastRequest $request
     * @return array
     */
    public function getForecast(ForecastRequest $request): array
    {
        return $this->weatherService->getFiveDaysForecast($request->get('city'));
    }
}
