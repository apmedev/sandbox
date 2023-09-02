<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\MovieFetchService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(MovieFetchService::class, function ($app) {
            $httpClient = new \GuzzleHttp\Client();
    
            return new MovieFetchService($httpClient);
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
