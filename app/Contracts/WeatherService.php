<?php

namespace App\Contracts;

interface WeatherService
{
    public function getCityList(): array;

    public function getFiveDaysForecast(string $city): array;
}
