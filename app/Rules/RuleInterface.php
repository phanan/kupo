<?php

namespace App\Rules;

use App\Crawler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * @property-read string helpMessage
 * @property-read string passedMessage
 * @property-read string failedMessage
 */
interface RuleInterface
{
    /**
     * Check the rule.
     */
    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri): bool;

    /**
     * Get the critical level of the rule.
     */
    public function level(): string;

    /**
     * Get the message if the rule is passed.
     */
    public function passedMessage(): string;

    /**
     * Get the message if the rule failed.
     */
    public function failedMessage(): string;

    /**
     * Get the help message for the rule.
     */
    public function helpMessage(): string;
}
