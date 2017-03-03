<?php

namespace Tests\Rules;

use App\Facades\UrlHelper;
use App\Rules\PageNotFoundGives404;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Tests\BrowserKitTestCase;

class PageNotFoundGives404Test extends BrowserKitTestCase
{
    public function testCheck()
    {
        UrlHelper::shouldReceive('getRootFileUrl')
            ->once()
            ->with('http://foo.bar/PlainResponse.txt', '/-~!page-to-test-404-responses-for-invalid-pages!~-')
            ->andReturn('http://foo.bar/-~!page-to-test-404-responses-for-invalid-pages!~-');

        $mock = new MockHandler([
            new Response(404),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $args = $this->createArgumentsFromMessage('PlainResponse');
        $rule = new PageNotFoundGives404($client);
        static::assertTrue($rule->check(...$args));
    }

    public function testCheckFails500()
    {
        $mock = new MockHandler([
            new Response(500),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $args = $this->createArgumentsFromMessage('PlainResponse');
        $rule = new PageNotFoundGives404($client);
        static::assertFalse($rule->check(...$args));
    }

    public function testCheckFails200()
    {
        $mock = new MockHandler([
            new Response(200),
        ]);

        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);

        $args = $this->createArgumentsFromMessage('PlainResponse');
        $rule = new PageNotFoundGives404($client);
        static::assertFalse($rule->check(...$args));
    }
}
