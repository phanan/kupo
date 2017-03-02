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
        return $this->client->request('GET', $url, [
            'headers' => [
                'User-Agent'      => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36',
                'Accept-Encoding' => 'gzip',
            ],
        ]);
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
