<?php

namespace App\Rules;

use App\Crawler;
use App\Services\Markdown;
use App\Services\UrlHelper;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * @property  $passedMessage string The message to display when the rule passes
 * @property  $failedMessage string The message to display when the rule fails
 * @property  $helpMessage string The help message, to provide more info about the rule
 */
abstract class Rule implements RuleInterface
{
    protected $markdown;
    protected $client;
    protected $urlHelper;

    public function __construct(Markdown $markdown, Client $client, UrlHelper $urlHelper)
    {
        $this->markdown = $markdown;
        $this->client = $client;
        $this->urlHelper = $urlHelper;
    }

    abstract public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri): bool;

    public function level(): string
    {
        return Levels::WARNING;
    }

    abstract public function passedMessage(): string;

    abstract public function failedMessage(): string;

    abstract public function helpMessage(): string;

    public function __get($name)
    {
        if (in_array($name, ['passedMessage', 'failedMessage', 'helpMessage'], true)) {
            return $this->markdown->parse($this->$name());
        }

        return $this->$name;
    }
}
