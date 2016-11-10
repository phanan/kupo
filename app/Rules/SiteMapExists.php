<?php

namespace App\Rules;

use App\Crawler;
use App\Facades\RobotsFile;
use App\Facades\UrlHelper;

class SiteMapExists extends Rule
{
    private $failedMsg;
    private $passedMsg;

    /**
     * @inheritdoc
     */
    public function check(Crawler $crawler = null, $url = null)
    {
        $parser = RobotsFile::getParser();
        if (!$maps = $parser->getSitemaps()) {
            $maps = [UrlHelper::getDefaultSiteMapUrl($url)];
        }

        $validMaps = [];
        $invalidMaps = [];

        foreach ($maps as $map) {
            $map = UrlHelper::absolutize($map, $url);
            if (UrlHelper::exists($map)) {
                $validMaps[] = "`$map`";
            } else {
                $invalidMaps[] = "`$map`";
            }
        }

        if ($invalidMaps) {
            $this->failedMsg = 'Site map(s) not found at '.implode(', ', $invalidMaps);

            return false;
        }

        $this->passedMsg = 'Site map(s) found at '.implode(', ', $validMaps);

        return true;
    }

    /**
     * @inheritdoc
     */
    public function passedMessage()
    {
        return $this->passedMsg;
    }

    /**
     * @inheritdoc
     */
    public function failedMessage()
    {
        return $this->failedMsg;
    }
}
