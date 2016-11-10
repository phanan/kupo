<?php

namespace App\Rules;

use App\Crawler;

class FacebookOGTagsExist  extends Rule
{
    /**
     * @inheritdoc
     */
    public function check(Crawler $crawler = null, $url = null)
    {
        return count($crawler->filter('meta[property="og:url"]'))
            && count($crawler->filter('meta[property="og:title"]'))
            && count($crawler->filter('meta[property="og:description"]'))
            && count($crawler->filter('meta[property="og:image"]'));
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
        return 'All basic Facebook Open Graph markups are implemented';
    }

    /**
     * @inheritdoc
     */
    public function failedMessage()
    {
        return 'At least one of `og:url`, `og:title`, `og:description`, and `og:image` meta property is missing';
    }
}
