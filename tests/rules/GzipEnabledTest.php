<?php

use App\Facades\UrlFetcher;
use App\Rules\GzipEnabled;

class GzipEnabledTest extends TestCase
{
    public function testCheck()
    {
        UrlFetcher::shouldReceive('isGzipped')
            ->once()
            ->andReturn(true);
        static::assertTrue((new GzipEnabled())->check());
    }
}
