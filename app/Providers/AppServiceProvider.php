<?php

namespace App\Providers;
use App\Interfaces\AirportsInterface;
use App\Repositories\AirportsRepository;

use Illuminate\Support\ServiceProvider;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
          $this->app->bind(AirportsInterface::class, AirportsRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
