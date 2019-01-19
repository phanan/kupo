<?php

namespace App\Rules;

use App\Crawler;
use GuzzleHttp\Exception\BadResponseException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class PageNotFoundGives404 extends Rule
{
    public const NOT_FOUND_PATH = '/-~!page-to-test-404-responses-for-invalid-pages!~-';

    private $statusCode;

    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri): bool
    {
        $uri = $this->urlHelper->getRootFileUrl((string) $uri, self::NOT_FOUND_PATH);

        try {
            $response = $this->client->get($uri);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
        }

        $this->statusCode = $response ? $response->getStatusCode() : null;

        return $this->statusCode === 404;
    }

    public function level(): string
    {
        return Levels::CRITICAL;
    }

    public function passedMessage(): string
    {
        return 'Not found page correctly returns a `404` status code.';
    }

    public function failedMessage(): string
    {
        return "Not found page returned a `{$this->statusCode}` instead of `404` status code.";
    }

    public function helpMessage(): string
    {
        return <<<'MSG'
Make sure every page returns the correct status code. Pages not returning 404 will be indexed by search engines.
MSG;
    }
}
