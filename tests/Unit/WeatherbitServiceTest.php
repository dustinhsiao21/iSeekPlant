<?php

namespace Tests\Unit;

use App\Services\WeatherbitService;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use Tests\FakeAPIData\WeatherData;
use Tests\TestCase;

class WeatherbitServiceTest extends TestCase
{
    use WeatherData;

    public function setUp(): void
    {
        parent::setUp();
        $this->service = new WeatherbitService($this->getMockHandler());
    }

    /**
     * Test get city test.
     *
     * @return void
     */
    public function testGetCityList()
    {
        $result = $this->service->getCityList();
        $this->assertNotCount(0, $result);
    }

    /**
     * Test if city name not exist.
     *
     * @return void
     */
    public function testGetFiveDaysForecastInputError()
    {
        $cityName = 'I_AM_NOT_A_CITY';
        $this->expectException('exception');
        $this->expectExceptionMessage("Can not find the city: $cityName");
        $this->service->getFiveDaysForecast($cityName);
    }

    /**
     * Test get 5 days forecast.
     *
     * @return void
     */
    public function testGetFiveDaysForecast()
    {
        $input = 'sydney';
        $result = $this->service->getFiveDaysForecast($input);

        $this->assertCount(5, $result['data']);

        $forecast = $result['data'][0];

        $this->assertArrayHasKey('datetime', $forecast);
        $this->assertArrayHasKey('weather', $forecast);
        $this->assertArrayHasKey('high_temp', $forecast);
        $this->assertArrayHasKey('low_temp', $forecast);
        $this->assertArrayHasKey('pop', $forecast);
    }

    /**
     * Mock the Client(Prevent sending request to the third-party API).
     *
     * @return void
     */
    private function getMockHandler()
    {
        return new MockHandler([
            new Response(200, [], json_encode($this->FackForecastData())),
        ]);
    }
}
