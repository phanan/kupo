<?php

namespace App\Services;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class UrlFetcher
{
    /**
     * @var Client
     */
    private $client;

    public function __construct(Client $client = null)
    {
        $this->setClient($client ?: new Client());
    }

    /**
     * Fetch an URL.
     *
     * @param $url string
     *
     * @throws \RuntimeException
     *
     * @return ResponseInterface
     */
    public function fetch($url)
    {
        return $this->client->request('GET', $url);
    }

    /**
     * Set the HTTP Client.
     *
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }
}
