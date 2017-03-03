<?php

namespace App\Rules;

use App\Crawler;
use App\Facades\UrlHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class PageNotFoundGives404 extends Rule
{
    protected $statusCode;

    /** @var Client */
    protected $client;

    /**
     * Check if Not Found pages return a correct 404 Status Code.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri)
    {
        $uri = UrlHelper::getRootFileUrl((string) $uri, '/-~!page-to-test-404-responses-for-invalid-pages!~-');

        try {
            $response = $this->client->get($uri);
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
        }

        $this->statusCode = $response ? $response->getStatusCode() : '-';

        return $this->statusCode === 404;
    }

    /**
     * {@inheritdoc}
     */
    public function level()
    {
        return Levels::CRITICAL;
    }

    /**
     * {@inheritdoc}
     */
    public function passedMessage()
    {
        return 'Not found page correctly return a `404` status.';
    }

    /**
     * {@inheritdoc}
     */
    public function failedMessage()
    {
        return 'Not found page returned `'.$this->statusCode.'` instead of `404`.';
    }

    /**
     * {@inheritdoc}
     */
    public function helpMessage()
    {
        return <<<'MSG'
Make sure every page returns the correct status code. Pages not returning 404 will be indexed by search engines.
MSG;
    }
}
