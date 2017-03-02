<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class Markdown extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\Markdown::class;
    }
}
