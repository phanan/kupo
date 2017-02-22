<?php

namespace App\Rules;

class TwitterOGTagsExist extends Rule
{
    /**
     * {@inheritdoc}
     */
    public function check()
    {
        return count($this->crawler->filter('meta[name="twitter:card"]'))
        && count($this->crawler->filter('meta[name="twitter:title"]'))
        && count($this->crawler->filter('meta[name="twitter:description"]'))
        && count($this->crawler->filter('meta[name="twitter:image"]'));
    }

    /**
     * {@inheritdoc}
     */
    public function level()
    {
        return Levels::NOTICE;
    }

    /**
     * {@inheritdoc}
     */
    public function passedMessage()
    {
        return 'All basic Twitter Card markups are implemented.';
    }

    /**
     * {@inheritdoc}
     */
    public function failedMessage()
    {
        return 'At least one of `twitter:card`, `twitter:title`, `twitter:description`, and `twitter:image` meta properties is missing.';
    }

    /**
     * {@inheritdoc}
     */
    public function helpMessage()
    {
        return <<<'MSG'
Similar to Facebook, Twitter has its own set of Open Graph markups (called “Twitter Card Tags”) for sharing on Twitter. Here is the [Cards Markup Tag Reference](https://dev.twitter.com/cards/markup), kupo!
MSG;
    }
}
