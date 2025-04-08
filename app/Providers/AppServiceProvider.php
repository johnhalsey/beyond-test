<?php

namespace App\Providers;

use App\Services\WondeService;
use Illuminate\Support\ServiceProvider;
use App\Contracts\SchoolDataServiceInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SchoolDataServiceInterface::class, WondeService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
