<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class UrlFetcher extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\UrlFetcher::class;
    }
}
