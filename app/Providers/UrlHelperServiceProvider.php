<?php

namespace App\Providers;

use App\Services\UrlHelper;
use Illuminate\Support\ServiceProvider;

class UrlHelperServiceProvider extends ServiceProvider
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
        $this->app->singleton(UrlHelper::class);
    }
}
