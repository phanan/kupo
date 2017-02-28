<?php

namespace App\Services;

use App\Crawler;

use App\Services\UrlFetcher;
use App\Facades\UrlHelper;
use App\Rules\Levels;
use App\Rules\Rule;
use App\Rules\RuleInterface;
use Exception;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Contracts\Container\Container;
use Psr\Http\Message\UriInterface;

class Checker
{
    /** @var  Container */
    private $container;

    /** @var UrlFetcher */
    private $fetcher;

    /** @var RobotsFile  */
    private $robotsFile;

    /**
     * Construct a new instance of this service.
     *
     * @param Container $container
     * @param \App\Services\UrlFetcher $fetcher
     * @param RobotsFile $robotsFile
     *
     */
    public function __construct(Container $container, UrlFetcher $fetcher, RobotsFile $robotsFile)
    {
        $this->container = $container;
        $this->fetcher = $fetcher;
        $this->robotsFile = $robotsFile;
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
        $this->robotsFile->setUrl(UrlHelper::getRobotsUrl($uri));

        $crawler = new Crawler($response);

        foreach ((array) config('rules') as $ruleClassName) {
            /** @var Rule $rule */
            $rule = app()->make($ruleClassName);

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
