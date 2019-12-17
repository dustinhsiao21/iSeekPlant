<?php

namespace App\Console\Commands;

use App\Contracts\WeatherService;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class WeatherReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:report {cities}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'generate a weather report';

    private $weatherService;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(WeatherService $weatherService)
    {
        parent::__construct();
        $this->weatherService = $weatherService;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Get the arguments
        $city = $this->argument('cities');
        $cityArray = explode(',', $this->argument('cities'));

        // Set the data report table
        $header = ['city', 'datetime', 'description', 'high_temp', 'low_temp'];
        $result = [];

        foreach ($cityArray as $city) {
            try {
                $forecast = $this->weatherService->getFiveDaysForecast($city);
                $city = $forecast['city_name'];
                foreach ($forecast['data'] as $day) {
                    $result[] = [
                        'city' => $city,
                        'datetime' => $day['datetime'],
                        'description' => $day['weather']['description'],
                        'high_temp' => $day['high_temp'],
                        'low_temp' => $day['low_temp'],
                    ];
                }
            } catch (Exception $e) {
                Log::error($e->getMessage());
                $this->error($e->getMessage());
            }
        }

        if (count($result)) {
            $this->table($header, $result);
        } else {
            $this->info('No output result');
        }
    }
}
