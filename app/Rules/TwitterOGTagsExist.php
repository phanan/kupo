<?php

namespace App\Rules;

use App\Crawler;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class TwitterOGTagsExist extends Rule
{
    /** @throws Exception */
    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri): bool
    {
        return count($crawler->filterCaseInsensitiveAttribute('meta[name="twitter:card"]'))
            && count($crawler->filterCaseInsensitiveAttribute('meta[name="twitter:title"]'))
            && count($crawler->filterCaseInsensitiveAttribute('meta[name="twitter:description"]'))
            && count($crawler->filterCaseInsensitiveAttribute('meta[name="twitter:image"]'));
    }

    public function level(): string
    {
        return Levels::NOTICE;
    }

    public function passedMessage(): string
    {
        return 'All basic Twitter Card markups are implemented.';
    }

    public function failedMessage(): string
    {
        return 'At least one of `twitter:card`, `twitter:title`, `twitter:description`, and `twitter:image` meta properties is missing.';
    }

    public function helpMessage(): string
    {
        return <<<MSG
Similar to Facebook, Twitter has its own set of Open Graph markups (called “Twitter Card Tags”) for sharing on Twitter. Here is the [Cards Markup Tag Reference](https://dev.twitter.com/cards/markup), kupo!
MSG;
    }
}
