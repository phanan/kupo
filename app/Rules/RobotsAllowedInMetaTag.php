<?php

namespace App\Rules;

use App\Crawler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class RobotsAllowedInMetaTag extends Rule
{
    /**
     * {@inheritdoc}
     */
    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri)
    {
        if (!count($tags = $crawler->filterCaseInsensitiveAttribute('meta[name=robots]'))) {
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
     * {@inheritdoc}
     */
    public function level()
    {
        return Levels::CRITICAL;
    }

    /**
     * {@inheritdoc}
     */
    public function passedMessage()
    {
        return '`ROBOTS` meta tag with `NOINDEX` and/or `NOFOLLOW` value not found.';
    }

    /**
     * {@inheritdoc}
     */
    public function failedMessage()
    {
        return '`ROBOTS` meta tag with `NOINDEX` and/or `NOFOLLOW` value found.';
    }

    /**
     * {@inheritdoc}
     */
    public function helpMessage()
    {
        return <<<'MSG'
A page can tell search engines to NOT index or follow its content with a `<meta name="robots" value="noindex, nofollow">` tag. Since you’re launching to public, this is hardly what you want, kupo!   
MSG;
    }
}
