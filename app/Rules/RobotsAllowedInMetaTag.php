<?php

namespace App\Rules;

use App\Crawler;
use DOMElement;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class RobotsAllowedInMetaTag extends Rule
{
    /** @throws Exception */
    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri): bool
    {
        if (!count($tags = $crawler->filterCaseInsensitiveAttribute('meta[name=robots]'))) {
            return true;
        }

        return !collect($tags)->contains(function (DOMElement $tag): bool {
            return $this->tagContainsNoIndexOrNoFollowContent($tag);
        });
    }

    private function tagContainsNoIndexOrNoFollowContent(DOMElement $tag): bool
    {
        return str_contains(strtolower($tag->getAttribute('content')), ['noindex', 'nofollow']);
    }

    public function level(): string
    {
        return Levels::CRITICAL;
    }

    public function passedMessage(): string
    {
        return '`ROBOTS` meta tag with `NOINDEX` and/or `NOFOLLOW` value not found.';
    }

    public function failedMessage(): string
    {
        return '`ROBOTS` meta tag with `NOINDEX` and/or `NOFOLLOW` value found.';
    }

    public function helpMessage(): string
    {
        return <<<MSG
A page can tell search engines to NOT index or follow its content with a `<meta name="robots" value="noindex, nofollow">` tag. Since you’re launching to public, this is hardly what you want, kupo!   
MSG;
    }
}
