<?php

namespace App\Services;

use App\Contracts\WeatherService;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Cache;

class WeatherbitService implements WeatherService
{
    /**
     * use client to request api.
     *
     * @var Client
     */
    private $client;

    const FORECAST_URL = 'forecast/daily';
    const TYPE = [
        self::FORECAST_URL => 'forecast',
    ];

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct($handler = null)
    {
        $this->client = new Client([
            'base_uri' => config('weather.weatherbit.base_url'),
            'handler' => $handler,
        ]);
    }

    /**
     * Get City List.
     *
     * @return array
     */
    public function getCityList(): array
    {
        $json = file_get_contents(storage_path('/app/city.json'));

        return json_decode($json, true);
    }

    /**
     * Get 5-days forecast.
     *
     * @param string $cityName city name
     * @return array
     */
    public function getFiveDaysForecast(string $cityName): array
    {
        $cityId = $this->getCityId(strtolower($cityName));
        if ($cityId == false) {
            throw new Exception("Can not find the city: $cityName");
        }

        // I think there is a bug in the weatherbit api when sending request with 6 days.
        // The return data does not always start on the same day.
        // So I send the request with 7 days at this stage.
        $response = $this->action('GET', self::FORECAST_URL, [
            'city_id' => $cityId,
            'days' => 7,
            'key' => config('weather.weatherbit.key'),
        ]);

        $fiveDays = [];
        $date = Carbon::now('Australia/Sydney')->add(1, 'day');
        $count = 0;
        foreach ($response['data'] as $day) {
            if ($count >= 5) {
                break;
            }

            if ($day['datetime'] == $date->format('Y-m-d')) {
                $fiveDays[] = $day;
                $date->add(1, 'day');
                $count++;
            }
        }

        $response['data'] = $fiveDays;

        return $response;
    }

    /**
     * Use city name to get the city id.
     *
     * @param string $cityName city name
     * @return string city id
     */
    protected function getCityId(string $cityName): string
    {
        $list = $this->getCityList();
        // format to ['id' => 'lowerCityName']
        $listArray = array_combine(array_column($list, 'id'), array_map('strtolower', array_column($list, 'city_name')));

        return array_search($cityName, $listArray);
    }

    /**
     * Send Api.
     *
     * @param string $method HTTP method
     * @param string $url request resource
     * @param array $parameters query data
     * @return array api response
     */
    protected function action(string $method, string $url, array $parameters): array
    {
        $today = Carbon::now('UTC')->format('Y-m-d');
        $cacheName = implode('_', [$today, self::TYPE[$url], $parameters['city_id']]);

        if ('GET' == $method) {
            $request = [
                'query' => $parameters,
            ];
        } else {
            $request = [
                'form_params' => $parameters,
            ];
        }

        return Cache::remember($cacheName, 60 * 24, function () use ($method, $url, $request) {
            $response = $this->client->request($method, $url, $request);

            return json_decode($response->getBody(), true);
        });
    }
}
