<?php

namespace App\Providers;

use App\Services\UrlFetcher;
use Illuminate\Support\ServiceProvider;
use PhpInsights\InsightsCaller;

class GoogleInsightsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(InsightsCaller::class, function () {
            return new InsightsCaller(config('services.google.key'), config('app.locale'));
        });
    }
}
