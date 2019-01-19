<?php

namespace App\Rules;

use App\Crawler;
use App\Services\Markdown;
use App\Services\RobotsTxtFile;
use App\Services\UrlHelper;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class RobotsAllowedInTxt extends Rule
{
    private $robotsTxtFile;

    public function __construct(Markdown $markdown, Client $client, UrlHelper $urlHelper, RobotsTxtFile $robotsTxtFile)
    {
        parent::__construct($markdown, $client, $urlHelper);

        $this->robotsTxtFile = $robotsTxtFile;
    }

    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri): bool
    {
        $this->robotsTxtFile->setUrl($this->urlHelper->getRobotsTxtUrl((string) $uri));

        if (!$this->robotsTxtFile->getContent()) {
            return true;
        }

        // To simplify our case, only check if
        //   User-agent: *
        //   Disallow: /
        // appears in the file.
        return $this->robotsTxtFile->isPathAllowed('/');
    }

    public function level(): string
    {
        return Levels::CRITICAL;
    }

    public function passedMessage(): string
    {
        return 'Search engines are not banned by `robots.txt`.';
    }

    public function failedMessage(): string
    {
        return 'Search engines are banned by `robots.txt`.';
    }

    public function helpMessage(): string
    {
        return <<<'MSG'
A site can also specify crawling instructions in a file named [`robots.txt`](http://www.robotstxt.org/robotstxt.html), placed at the root of its public directory. Having 
```
User-agent: *
Disallow: /
``` 
in this file essentially tells search engines to NOT visit (and index) any page on the site, kupo!
MSG;
    }
}
