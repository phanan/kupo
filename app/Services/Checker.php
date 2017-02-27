<?php

namespace App\Services;

use App\Crawler;
use App\Facades\RobotsFile;
use App\Facades\UrlFetcher;
use App\Facades\UrlHelper;
use App\Rules\Levels;
use App\Rules\Rule;
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
     * @throws Exception
     *
     * @return \Generator
     */
    public function validate($url = null)
    {
        if ($url) {
            $this->setUrl($url);
        }

        if (!$this->url) {
            throw new Exception('URL not set.');
        }

        $html = UrlFetcher::fetch($this->url);
        RobotsFile::setUrl(UrlHelper::getRobotsUrl($this->url));

        $crawler = new Crawler($html, $this->url);

        foreach ((array) config('rules') as $ruleClassName) {
            /** @var Rule $rule */
            $rule = new $ruleClassName($crawler, $this->getUrl());

            try {
                $result = $rule->check();
                yield [
                    'passed'  => $result,
                    'message' => $result ? $rule->passedMessage : $rule->failedMessage,
                    'help'    => $rule->helpMessage,
                    'level'   => $rule->level(),
                ];
            } catch (Exception $e) {
            }
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
