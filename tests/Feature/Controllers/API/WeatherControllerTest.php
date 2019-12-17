<?php

namespace Tests\Feature\Controllers\API;

use App\Contracts\WeatherService;
use Tests\TestCase;

class WeatherControllerTest extends TestCase
{
    /**
     * Test Get Cities.
     *
     * @return void
     */
    public function testGetCities()
    {
        $response = $this->json('GET', route('api::city_lists'))
                ->assertSuccessful();

        $data = $response->decodeResponseJson()[0];
        $this->assertArrayHasKey('id', $data);
        $this->assertArrayHasKey('city_name', $data);
    }

    /**
     * Test Get 5 days Forecast.
     *
     * @return void
     */
    public function testGetForecast()
    {
        $city = 'sydney';

        $mock = $this->mockService();
        $mock->shouldReceive($city)->andReturn([]);

        $this->json('GET', route('api::five_days_forecast', ['city' => $city]))
            ->assertSuccessful();
    }

    /**
     * Test Get 5 days Forecast with invalid arguments.
     *
     * @return void
     */
    public function testGetForecastFail()
    {
        $city = [];

        $this->mockService();

        $this->json('GET', route('api::five_days_forecast', ['city' => $city]))
            ->assertStatus(422);
    }

    /**
     * Mock the WeatherService.
     *
     * @return void
     */
    public function mockService()
    {
        return $this->initMock(WeatherService::class, ['getFiveDaysForecast' => []]);
    }
}
