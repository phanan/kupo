<?php

namespace App\Rules;

use App\Crawler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

interface RuleInterface
{
    /**
     * Check the rule.
     *
     * @param Crawler           $crawler
     * @param ResponseInterface $response
     * @param UriInterface      $uri
     *
     * @return bool
     */
    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri);

    /**
     * Get the critical level of the rule.
     *
     * @return string
     */
    public function level();

    /**
     * Get the message if the rule is passed.
     *
     * @return string
     */
    public function passedMessage();

    /**
     * Get the message if the rule failed.
     *
     * @return string
     */
    public function failedMessage();

    /**
     * Get the help message for the rule.
     *
     * @return string
     */
    public function helpMessage();
}
