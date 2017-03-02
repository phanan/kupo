<?php

namespace Tests;

use App\Services\UrlFetcher;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class UrlFetcherTest extends BrowserKitTestCase
{
    public function testFetch()
    {
        $mock = new MockHandler([
            new Response(200, [], '<html><body>Normal</body></html>'),
        ]);

        $client = new Client(['handler' => HandlerStack::create($mock)]);
        $fetcher = new UrlFetcher($client);

        static::assertEquals('<html><body>Normal</body></html>', (string) $fetcher->fetch('http://foo.bar')->getBody());
    }
}
