<?php

namespace App\Rules;

use App\Crawler;

interface RuleInterface
{
    /**
     * Check the DOM against the rule.
     *
     * @param Crawler     $crawler
     * @param string|null $url
     *
     * @return bool
     */
    public function check(Crawler $crawler = null, $url = null);

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
}
