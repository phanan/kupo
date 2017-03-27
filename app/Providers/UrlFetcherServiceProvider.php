<?php

namespace App\Providers;

use App\Services\UrlFetcher;
use Illuminate\Support\ServiceProvider;

class UrlFetcherServiceProvider extends ServiceProvider
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
        $this->app->singleton(UrlFetcher::class);
    }
}
