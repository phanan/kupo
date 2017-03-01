<?php

namespace App\Rules;

use App\Crawler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

/**
 * @property  $passedMessage string The message to display when the rule passes
 * @property  $failedMessage string The message to display when the rule fails
 * @property  $helpMessage string The help message, to provide more info about the rule
 */
abstract class Rule implements RuleInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    abstract public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri);

    /**
     * {@inheritdoc}
     */
    public function level()
    {
        return Levels::WARNING;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function passedMessage()
    {
        throw new \Exception('Unimplemented method.');
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function failedMessage()
    {
        throw new \Exception('Unimplemented method.');
    }

    /**
     * Get the help message for the rule.
     *
     * @throws \Exception
     *
     * @return string
     */
    public function helpMessage()
    {
        throw new \Exception('Unimplemented method.');
    }

    public function __get($name)
    {
        if (in_array($name, ['passedMessage', 'failedMessage', 'helpMessage'], true)) {
            return md($this->$name());
        }

        return $this->$name;
    }
}
