<?php

namespace App\Providers;

use App\Services\Markdown;
use Illuminate\Support\ServiceProvider;

class MarkdownServiceProvider extends ServiceProvider
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
        $this->app->singleton(Markdown::class, function () {
            return new Markdown();
        });
    }
}
