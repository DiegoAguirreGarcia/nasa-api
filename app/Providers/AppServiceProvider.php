<?php

namespace App\Providers;

use App\Interfaces\NasaRepositoryInterface;
use App\Repositories\NasaRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(NasaRepositoryInterface::class, NasaRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
