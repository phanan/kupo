<?php

use App\Services\UrlFetcher;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class UrlFetcherTest extends TestCase
{
    public function testFetch()
    {
        $mock = new MockHandler([
            new Response(200, [], '<html><body>Normal</body></html>'),
            new Response(200, [], gzencode('<html><body>Gzipped</body></html>')),
        ]);

        $client = new Client(['handler' => HandlerStack::create($mock)]);
        $fetcher = new UrlFetcher($client);

        static::assertEquals('<html><body>Normal</body></html>', $fetcher->fetch('http://foo.bar'));
        static::assertFalse($fetcher->isGzipped());
        static::assertEquals('<html><body>Gzipped</body></html>', $fetcher->fetch('http://foo.bar'));
        static::assertTrue($fetcher->isGzipped());
    }
}
