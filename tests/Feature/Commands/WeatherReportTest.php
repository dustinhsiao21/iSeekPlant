<?php

namespace Tests\Feature\Commands;

use App\Contracts\WeatherService;
use Artisan;
use Tests\FakeAPIData\WeatherData;
use Tests\TestCase;

class WeatherReportTest extends TestCase
{
    use WeatherData;

    /**
     * Test Command need cities arguments.
     *
     * @return void
     */
    public function testHandleNeedArguments()
    {
        $this->expectException('RuntimeException');
        $this->expectExceptionMessage('Not enough arguments (missing: "cities").');
        Artisan::call('weather:report');
    }

    /**
     * Test Command need valid cities.
     *
     * @return void
     */
    public function testHandleCityNotFound()
    {
        $cities = 'cccccc';

        Artisan::call("weather:report $cities");
        $output = Artisan::output();
        // check the error message
        $this->assertStringContainsString("Can not find the city: cccccc\n", $output);
        // check the No output result
        $this->assertStringContainsString('No output result', $output);
    }

    /**
     * Test handling report that includes headers.
     *
     * @return void
     */
    public function testHandle()
    {
        $cities = 'sydney';
        $mock = $this->mockService();
        $mock->shouldReceive($cities);

        Artisan::call('weather:report sydney');
        $output = Artisan::output();
        // check the header
        $this->assertStringContainsString('city', $output);
        $this->assertStringContainsString('datetime', $output);
        $this->assertStringContainsString('description', $output);
        $this->assertStringContainsString('high_temp', $output);
        $this->assertStringContainsString('low_temp', $output);
    }

    public function mockService()
    {
        $data = $this->FackForecastData();
        array_shift($data['data']);

        return $this->initMock(WeatherService::class, ['getFiveDaysForecast' => $data]);
    }
}
