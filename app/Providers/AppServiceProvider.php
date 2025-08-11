<?php

namespace App\Providers;
use App\Interfaces\AirportsInterface;
use App\Interfaces\FlightInterface;
use App\Repositories\AirportsRepository;
use App\Repositories\FlightRepository;

use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
          $this->app->bind(AirportsInterface::class, AirportsRepository::class);
          $this->app->bind(FlightInterface::class, FlightRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
