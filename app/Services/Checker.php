<?php

namespace App\Services;

use App\Crawler;
use App\Rules\Levels;
use App\Rules\Rule;
use Exception;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Contracts\Container\Container;

class Checker
{
    /** @var  Container */
    private $container;

    /** @var UrlFetcher */
    private $fetcher;

    /** @var RobotsFile  */
    private $robotsFile;

    /** @var UrlHelper  */
    private $urlHelper;

    /**
     * Construct a new instance of this service.
     *
     * @param Container $container
     * @param \App\Services\UrlFetcher $fetcher
     * @param RobotsFile $robotsFile
     * @param UrlHelper $urlHelper
     */
    public function __construct(Container $container, UrlFetcher $fetcher, RobotsFile $robotsFile, UrlHelper $urlHelper)
    {
        $this->container = $container;
        $this->fetcher = $fetcher;
        $this->robotsFile = $robotsFile;
        $this->urlHelper = $urlHelper;
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
    public function validate($url)
    {
        $uri = new Uri($url);

        $response = $this->fetcher->fetch($uri);

        $this->robotsFile->setUrl($this->urlHelper->getRobotsUrl($uri));

        $crawler = new Crawler($response, $uri);

        foreach ((array) config('rules') as $ruleClassName) {
            /** @var Rule $rule */
            $rule = $this->container->make($ruleClassName);

            try {
                $result = $rule->check($crawler, $response, $uri);
                yield [
                    'passed'  => $result,
                    'message' => $result ? $rule->passedMessage : $rule->failedMessage,
                    'help'    => $rule->helpMessage,
                    'level'   => $rule->level(),
                ];
            } catch (Exception $e) {
                yield [
                    'passed'  => false,
                    'message' => "Error checking rule `{$ruleClassName}`.",
                    'help'    => config('app.debug') ? (string) $e : null,
                    'level'   => Levels::ERROR,
                ];
            }
        }
    }
}
