<?php

namespace App\Rules;

use App\Crawler;

class TwitterOGTagsExist extends Rule
{
    /**
     * @inheritdoc
     */
    public function check(Crawler $crawler = null, $url = null)
    {
        return count($crawler->filter('meta[name="twitter:card"]'))
        && count($crawler->filter('meta[name="twitter:title"]'))
        && count($crawler->filter('meta[name="twitter:description"]'))
        && count($crawler->filter('meta[name="twitter:image"]'));
    }

    /**
     * @inheritdoc
     */
    public function level()
    {
    return Levels::NOTICE;
    }

    /**
     * @inheritdoc
     */
    public function passedMessage()
    {
        return 'All basic Twitter Card markups are implemented';
    }

    /**
     * @inheritdoc
     */
    public function failedMessage()
    {
        return 'At least one of `twitter:card`, `twitter:title`, `twitter:description`, and `twitter:image` meta property is missing';
    }
}
