<?php

namespace App\Rules;

use App\Facades\RobotsFile;
use App\Facades\UrlHelper;

class SiteMapExists extends Rule
{
    private $failedMsg;
    private $passedMsg;

    /**
     * {@inheritdoc}
     */
    public function check()
    {
        $parser = RobotsFile::getParser();
        if (!$maps = $parser->getSitemaps()) {
            $maps = [UrlHelper::getDefaultSiteMapUrl($this->url)];
        }

        $validMaps = [];
        $invalidMaps = [];

        foreach ($maps as $map) {
            $map = UrlHelper::absolutize($map, $this->url);
            if (UrlHelper::exists($map)) {
                $validMaps[] = "`$map`";
            } else {
                $invalidMaps[] = "`$map`";
            }
        }

        if ($invalidMaps) {
            $this->failedMsg = 'Site map(s) not found at '.implode(', ', $invalidMaps).'.';

            return false;
        }

        $this->passedMsg = 'Site map(s) found at '.implode(', ', $validMaps).'.';

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function helpMessage()
    {
        return <<<MSG
An [XML Sitemap](https://en.wikipedia.org/wiki/Site_map#XML_Sitemaps) is a structured format that a user doesn’t need to see, but it tells the search engine about the pages in a site, their relative importance to each other, and how often they are updated. Having a proper, up-to-date sitemap can greatly benefit your site’s SEO result, thus is highly recommended, kupo!  
MSG;
    }
}
