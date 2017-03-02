<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

class RobotsFile extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \App\Services\RobotsFile::class;
    }
}
