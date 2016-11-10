<?php

namespace App\Rules;

use App\Crawler;
use App\Facades\RobotsFile;

class RobotsAllowedInTxt extends Rule
{
    /**
     * @inheritdoc
     */
    public function check(Crawler $crawler = null, $url = null)
    {
        if (!$content = RobotsFile::getContent()) {
            return true;
        }

        // To simplify our case, only check if
        //   User-agent: *
        //   Disallow: /
        // appears in the file.

        $parser = RobotsFile::getParser();
        $parser->setUserAgent('*');

        return $parser->isAllowed('/');
    }

    /**
     * @inheritdoc
     */
    public function level()
    {
        return Levels::CRITICAL;
    }

    /**
     * @inheritdoc
     */
    public function passedMessage()
    {
        return 'Search engines are not banned by `robots.txt`';
    }

    /**
     * @inheritdoc
     */
    public function failedMessage()
    {
        return 'Search engines are banned by `robots.txt`';
    }
}
