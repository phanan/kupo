<?php

namespace App\Rules;

use App\Crawler;

class AppIconsExist extends Rule
{
    /**
     * @inheritdoc
     * @throws \RuntimeException
     */
    public function check(Crawler $crawler = null, $url = null)
    {
        // To keep things simple, we only check for the tags' existence,
        // not the icon files themselves.
        return
            count($crawler->filter('link[rel=apple-touch-icon]')) &&
            count($crawler->filter('link[rel=icon]'));
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
        return 'App icons for mobile devices found';
    }

    /**
     * @inheritdoc
     */
    public function failedMessage()
    {
        return 'App icons for mobile devices not found';
    }
}
