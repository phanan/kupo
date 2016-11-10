<?php

namespace App\Rules;

use App\Crawler;
use App\Facades\UrlHelper;

class FaviconExists extends Rule
{
    /**
     * @var string
     */
    private $faviconUrl;

    /**
     * @inheritdoc
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function check(Crawler $crawler = null, $url = null)
    {
        // Find the favicon URL from the HTML
        $links = $crawler->filter('link[rel="icon"], link[rel="shortcut icon"]');

        // If we can find it, use it. Otherwise, resort to the root favicon.ico.
        $this->faviconUrl = count($links) ?
            $links->first()->attr('href') :
            UrlHelper::getDefaultFaviconUrl($url);

        $this->faviconUrl = UrlHelper::absolutize($this->faviconUrl, $url);

        return UrlHelper::exists($this->faviconUrl);
    }

    /**
     * @inheritdoc
     */
    public function level()
    {
        return Levels::NOTICE;
    }

    /**
     * @inheritdoc
     */
    public function passedMessage()
    {
        return "Favicon found at `{$this->faviconUrl}`";
    }

    /**
     * @inheritdoc
     */
    public function failedMessage()
    {
        return "Favicon not found at `{$this->faviconUrl}`";
    }
}
