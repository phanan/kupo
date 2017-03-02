<?php

namespace App\Rules;

use App\Crawler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class FacebookOGTagsExist extends Rule
{
    /**
     * {@inheritdoc}
     */
    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri)
    {
        return count($crawler->filterCaseInsensitiveAttribute('meta[property="og:url"]'))
            && count($crawler->filterCaseInsensitiveAttribute('meta[property="og:title"]'))
            && count($crawler->filterCaseInsensitiveAttribute('meta[property="og:description"]'))
            && count($crawler->filterCaseInsensitiveAttribute('meta[property="OG:image"]'));
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
        return <<<'MSG'
Though not mandatory, a page should have valid Open Graph (OG) markups to take control over how the content appears on Facebook. You can about them [here](https://developers.facebook.com/docs/sharing/webmasters), kupo!
MSG;
    }
}
