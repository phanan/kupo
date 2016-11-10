<?php

namespace App\Rules;

use App\Crawler;
use App\Facades\UrlFetcher;

class GzipEnabled extends Rule
{
    public function check(Crawler $crawler = null, $url = null)
    {
        // We simply check the fetcher.
        return UrlFetcher::isGzipped();
    }

    /**
     * Get the level of the rule.
     *
     * @return string
     */
    public function level()
    {
        return Levels::NOTICE;
    }

    /**
     * Get the message if the rule is passed.
     *
     * @return string
     */
    public function passedMessage()
    {
        return 'Content is gzipped';
    }

    /**
     * Get the message if the rule failed.
     *
     * @return string
     */
    public function failedMessage()
    {
        return 'Content is not gzipped';
    }
}
