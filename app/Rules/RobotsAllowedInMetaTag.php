<?php

namespace App\Rules;

class RobotsAllowedInMetaTag extends Rule
{
    /**
     * @inheritdoc
     */
    public function check()
    {
        if (!count($tags = $this->crawler->filter('meta[name=robots]'))) {
            return true;
        }

        foreach ($tags as $tag) {
            if (str_contains(strtolower($tag->getAttribute('content')), ['noindex', 'nofollow'])) {
                return false;
            }
        }

        return true;
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
        return '`ROBOTS` meta tag with `NOINDEX` and/or `NOFOLLOW` value not found';
    }

    /**
     * @inheritdoc
     */
    public function failedMessage()
    {
        return '`ROBOTS` meta tag with `NOINDEX` and/or `NOFOLLOW` value found';
    }
}
