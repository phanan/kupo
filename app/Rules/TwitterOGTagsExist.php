<?php

namespace App\Rules;

use App\Crawler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class TwitterOGTagsExist extends Rule
{
    /**
     * {@inheritdoc}
     */
    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri)
    {
        return count($crawler->filterCaseInsensitiveAttribute('meta[name="twitter:card"]'))
        && count($crawler->filterCaseInsensitiveAttribute('meta[name="twitter:title"]'))
        && count($crawler->filterCaseInsensitiveAttribute('meta[name="twitter:description"]'))
        && count($crawler->filterCaseInsensitiveAttribute('meta[name="twitter:image"]'));
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
