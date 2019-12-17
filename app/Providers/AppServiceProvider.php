<?php

namespace App\Providers;

use App\Contracts\WeatherService;
use App\Services\WeatherbitService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerServices();
    }

    private function registerServices()
    {
        $this->app->singleton(WeatherService::class, WeatherbitService::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
