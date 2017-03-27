<?php

namespace App\Providers;

use App\Services\RobotsFile;
use Illuminate\Support\ServiceProvider;

class RobotsFileServiceProvider extends ServiceProvider
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
        $this->app->singleton(RobotsFile::class);
    }
}
