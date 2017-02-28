<?php

namespace App\Rules;

use App\Crawler;

/**
 * @property  $passedMessage string The message to display when the rule passes
 * @property  $failedMessage string The message to display when the rule fails
 * @property  $helpMessage string The help message, to provide more info about the rule
 */
class Rule implements RuleInterface
{
    protected $url;
    protected $crawler;

    /**
     * {@inheritdoc}
     */
    public function __construct(Crawler $crawler = null, $url = null)
    {
        $this->crawler = $crawler;
        $this->url = $url;
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function check()
    {
        throw new \Exception('Unimplemented method.');
    }

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
