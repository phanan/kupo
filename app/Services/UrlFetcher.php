<?php

namespace App\Services;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;

class UrlFetcher
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function fetch(string $url): ResponseInterface
    {
        return $this->client->get($url);
    }
}
