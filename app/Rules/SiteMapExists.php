<?php

namespace App\Rules;

use App\Crawler;
use App\Services\Markdown;
use App\Services\RobotsTxtFile;
use App\Services\UrlHelper;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class SiteMapExists extends Rule
{
    private $failedMsg;
    private $passedMsg;
    private $robotsTxtFile;

    public function __construct(Markdown $markdown, Client $client, UrlHelper $urlHelper, RobotsTxtFile $robotsTxtFile)
    {
        parent::__construct($markdown, $client, $urlHelper);

        $this->robotsTxtFile = $robotsTxtFile;
    }

    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri): bool
    {
        $this->robotsTxtFile->setUrl($this->urlHelper->getRobotsTxtUrl((string) $uri));

        if (!$sitemaps = $this->robotsTxtFile->getSitemaps()) {
            $sitemaps = [$this->urlHelper->getDefaultSiteMapUrl((string) $uri)];
        }

        $validMaps = [];
        $invalidMaps = [];

        foreach ($sitemaps as $sitemap) {
            $sitemap = $this->urlHelper->absolutize($sitemap, (string) $uri);

            if ($this->urlHelper->exists($sitemap)) {
                $validMaps[] = "`$sitemap`";
            } else {
                $invalidMaps[] = "`$sitemap`";
            }
        }

        if ($invalidMaps) {
            $this->failedMsg = 'Site sitemap(s) not found at '.implode(', ', $invalidMaps).'.';

            return false;
        }

        $this->passedMsg = 'Site sitemap(s) found at '.implode(', ', $validMaps).'.';

        return true;
    }

    public function passedMessage(): string
    {
        return $this->passedMsg;
    }

    public function failedMessage(): string
    {
        return $this->failedMsg;
    }

    public function helpMessage(): string
    {
        return <<<MSG
An [XML Sitemap](https://en.wikipedia.org/wiki/Site_map#XML_Sitemaps) is a structured format that a user doesn’t need to see, but it tells the search engine about the pages in a site, their relative importance to each other, and how often they are updated. Having a proper, up-to-date sitemap can greatly benefit your site’s SEO result, thus is highly recommended, kupo!  
MSG;
    }
}
