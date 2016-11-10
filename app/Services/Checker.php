<?php

namespace App\Services;

use App\Crawler;
use App\Facades\RobotsFile;
use App\Facades\UrlFetcher;
use App\Facades\UrlHelper;
use Exception;

class Checker
{
    private $url;

    /**
     * Construct a new instance of this service.
     *
     * @param string $url
     *
     * @throws \Exception
     */
    public function __construct($url = null)
    {
        if ($url) {
            $this->setUrl($url);
        }
    }

    /**
     * Validate the URL against our checklist.
     *
     * @param string|null $url
     *
     * @return \Generator
     * @throws Exception
     */
    public function validate($url = null)
    {
        if ($url) {
            $this->setUrl($url);
        }

        if (!$this->url) {
            throw new Exception('URL not set.');
        }

        try {
            $html = UrlFetcher::fetch($this->url);
            RobotsFile::setUrl(UrlHelper::getRobotsUrl($this->url));
        } catch (Exception $e) {
            throw $e;
        }

        $crawler = new Crawler($html);

        foreach ((array) config('rules') as $rule) {
            $ruleClass = new $rule($crawler, $this->getUrl());

            try {
                $result = $ruleClass->check();
                yield [
                    'passed' => $result,
                    'message' => $result ? $ruleClass->passedMessage : $ruleClass->failedMessage,
                    'level' => $ruleClass->level(),
                ];
            } catch (Exception $e) {}
        }
    }

    /**
     * Set the URL to download.
     *
     * @param string $url
     *
     * @throws Exception
     */
    public function setUrl($url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new Exception('Invalid URL provided.');
        }

        $this->url = $url;
    }

    /**
     * Get the URL.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }
}
