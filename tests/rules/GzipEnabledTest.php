<?php

namespace Tests\Rules;

use App\Facades\UrlFetcher;
use App\Rules\GzipEnabled;
use Tests\BrowserKitTestCase;

class GzipEnabledTest extends BrowserKitTestCase
{
    public function testCheck()
    {
        UrlFetcher::shouldReceive('isGzipped')
            ->once()
            ->andReturn(true);
        static::assertTrue((new GzipEnabled())->check());
    }
}
