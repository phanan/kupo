<?php

namespace App\Rules;

class FacebookOGTagsExist  extends Rule
{
    /**
     * {@inheritdoc}
     */
    public function check()
    {
        return count($this->crawler->filter('meta[property="og:url"]'))
            && count($this->crawler->filter('meta[property="og:title"]'))
            && count($this->crawler->filter('meta[property="og:description"]'))
            && count($this->crawler->filter('meta[property="og:image"]'));
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
        return 'All basic Facebook Open Graph markups are implemented.';
    }

    /**
     * {@inheritdoc}
     */
    public function failedMessage()
    {
        return 'At least one of `og:url`, `og:title`, `og:description`, and `og:image` meta properties is missing.';
    }

    /**
     * {@inheritdoc}
     */
    public function helpMessage()
    {
        return <<<MSG
Though not mandatory, a page should have valid Open Graph (OG) markups to take control over how the content appears on Facebook. You can about them [here](https://developers.facebook.com/docs/sharing/webmasters), kupo!
MSG;
    }
}
