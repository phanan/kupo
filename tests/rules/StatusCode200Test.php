<?php

namespace Tests\Rules;

use App\Facades\UrlFetcher;
use App\Rules\GzipEnabled;
use App\Rules\StatusCode200;
use GuzzleHttp\Psr7\Response;
use Tests\BrowserKitTestCase;

class StatusCode200Test extends BrowserKitTestCase
{
    public function testCheckValid()
    {
        $response = new Response(200);

        UrlFetcher::shouldReceive('getResponse')
            ->once()
            ->andReturn($response);
        static::assertTrue((new StatusCode200())->check());
    }

    public function testCheckInvalid()
    {
        $response = new Response(500);

        UrlFetcher::shouldReceive('getResponse')
            ->once()
            ->andReturn($response);
        static::assertFalse((new StatusCode200())->check());
    }
}
