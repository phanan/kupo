<?php

namespace App\Rules;

use App\Crawler;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class FaviconExists extends Rule
{
    private $faviconUrl;

    /** @throws Exception */
    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri): bool
    {
        // Find the favicon URL from the HTML
        $links = $crawler->filterCaseInsensitiveAttribute('link[rel="icon"], link[rel="shortcut icon"]');

        // If we can find it, use it. Otherwise, resort to the root favicon.ico.
        $this->faviconUrl = count($links)
            ? $links->first()->link()->getUri()
            : $this->urlHelper->getDefaultFaviconUrl($uri);

        return $this->urlHelper->exists($this->faviconUrl);
    }

    public function level(): string
    {
        return Levels::NOTICE;
    }

    public function passedMessage(): string
    {
        return "Favicon found at `{$this->faviconUrl}`.";
    }

    public function failedMessage(): string
    {
        return "Favicon not found at `{$this->faviconUrl}`.";
    }

    public function helpMessage(): string
    {
        return <<<'MSG'
A [favicon](https://en.wikipedia.org/wiki/Favicon) (short for _favorite icon_) represents the site graphically on the tab bar or in bookmarks. If a favicon isn’t specified in the HTML markups, the browser will look for a file named `favicon.ico` at the root of the site, kupo! 
MSG;
    }
}
