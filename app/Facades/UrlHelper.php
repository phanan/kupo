<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class UrlHelper extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\UrlHelper::class;
    }
}
