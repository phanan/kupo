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

    /**
     * @var ResponseInterface
     */
    private $response;

    /**
     * Whether the content is gzipped.
     *
     * @var bool
     */
    private $gzipped;

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
     * @return string
     */
    public function fetch($url)
    {
        $this->response = $this->client->request('GET', $url, [
            'headers' => [
                'User-Agent'      => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36',
                'Accept-Encoding' => 'gzip',
            ],
            'decode_content' => false,
        ]);

        $this->gzipped = unpack('H*', $this->response->getBody()->read(2))[1] === '1f8b';

        return $this->gzipped ?
            gzdecode($this->response->getBody()) :
            (string) $this->response->getBody();
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

    /**
     * Get the Guzzle Response object.
     *
     * @return ResponseInterface
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Checks if the content is gzipped.
     *
     * @return bool
     */
    public function isGzipped()
    {
        return $this->gzipped;
    }
}
