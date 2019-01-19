<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use RobotsTxtParser;

class RobotsTxtFile
{
    private $client;

    /**
     * @var RobotsTxtParser
     */
    private $parser;

    /**
     * @var string
     */
    private $url;

    /**
     * Content of the robots.txt file.
     *
     * @var string
     */
    private $content;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the content of the robots.txt file.
     */
    public function getContent(): string
    {
        if ($this->content === null) {
            try {
                $this->content = (string) $this->client->get($this->url)->getBody();
            } catch (ClientException $e) {
                $this->content = '';
            }
        }

        return $this->content;
    }

    public function setUrl(string $url): void
    {
        $this->url = $url;
    }

    public function getParser(): RobotsTxtParser
    {
        if (!$this->parser) {
            $this->parser = new RobotsTxtParser($this->getContent());
        }

        return $this->parser;
    }

    public function isPathAllowed(string $path, string $userAgent = '*'): bool
    {
        $this->getParser()->setUserAgent($userAgent);

        return $this->getParser()->isAllowed($path);
    }

    public function getSitemaps(): array
    {
        return $this->getParser()->getSitemaps();
    }
}
