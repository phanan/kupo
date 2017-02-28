<?php

namespace Tests;

use App\Crawler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;
use Psr\Http\Message\ResponseInterface;

abstract class BrowserKitTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Create a Crawler instance from a blob file's content.
     *
     * @param $name string Name of the blob file.
     *
     * @return array
     */
    public function createArgumentsFromBlob($name)
    {
        if (!ends_with($name, '.html')) {
            $name = "$name.html";
        }

        $response = new Response(200, [], file_get_contents(__DIR__."/blobs/$name"));
        $uri = new Uri('http://foo.bar/' . $name);
        $crawler = new Crawler($response, $uri);

        return [$crawler, $response, $uri];
    }

    /**
     * Create a Crawler instance from a message file's content.
     *
     * @param $name string Name of the message file.
     *
     * @return array
     */
    public function createArgumentsFromMessage($name)
    {
        if (!ends_with($name, '.txt')) {
            $name = "$name.txt";
        }

        $response = \GuzzleHttp\Psr7\parse_response(file_get_contents(__DIR__."/messages/$name"));

        $uri = new Uri('http://foo.bar/' . $name);
        $crawler = new Crawler($response, $uri);

        return [$crawler, $response, $uri];
    }
}
