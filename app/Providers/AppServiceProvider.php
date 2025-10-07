<?php

namespace App\Providers;

use App\Services\YgoApiProxyService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(YgoApiProxyService::class, function ($app) {
            return new YgoApiProxyService;
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
