<?php

namespace App\Rules;

use App\Facades\UrlHelper;

class FaviconExists extends Rule
{
    /**
     * @var string
     */
    private $faviconUrl;

    /**
     * {@inheritdoc}
     */
    public function check()
    {
        // Find the favicon URL from the HTML
        $links = $this->crawler->filter('link[rel="icon"], link[rel="shortcut icon"]');

        // If we can find it, use it. Otherwise, resort to the root favicon.ico.
        $this->faviconUrl = count($links) ?
            $links->first()->attr('href') :
            UrlHelper::getDefaultFaviconUrl($this->url);

        $this->faviconUrl = UrlHelper::absolutize($this->faviconUrl, $this->url);

        return UrlHelper::exists($this->faviconUrl);
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
        return "Favicon found at `{$this->faviconUrl}`.";
    }

    /**
     * {@inheritdoc}
     */
    public function failedMessage()
    {
        return "Favicon not found at `{$this->faviconUrl}`.";
    }

    /**
     * {@inheritdoc}
     */
    public function helpMessage()
    {
        return <<<MSG
A [favicon](https://en.wikipedia.org/wiki/Favicon) (short for _favorite icon_) represents the site graphically on the tab bar or in bookmarks. If a favicon isn’t specified in the HTML markups, the browser will look for a file named `favicon.ico` at the root of the site, kupo! 
MSG;
    }
}
