<?php

namespace App\Services;

use App\Crawler;
use App\Rules\Levels;
use App\Rules\RuleInterface;
use Exception;
use GuzzleHttp\Psr7\Uri;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Logging\Log;

class Checker
{
    private $container;
    private $fetcher;
    private $urlHelper;
    private $markdown;
    private $logger;

    public function __construct(
        Container $container,
        UrlFetcher $fetcher,
        UrlHelper $urlHelper,
        Markdown $markdown,
        Log $logger
    ) {
        $this->container = $container;
        $this->fetcher = $fetcher;
        $this->urlHelper = $urlHelper;
        $this->markdown = $markdown;
        $this->logger = $logger;
    }

    /**
     * Check the URL against our checklist.
     */
    public function check(?string $url): array
    {
        $uri = new Uri($url);
        $response = $this->fetcher->fetch($uri);
        $crawler = new Crawler($response, $uri);

        return collect((array) config('rules'))
            ->map(static function (string $ruleClassName): RuleInterface {
                return app($ruleClassName);
            })
            ->map(function (RuleInterface $rule) use ($crawler, $response, $uri): array {
                try {
                    $result = $rule->check($crawler, $response, $uri);

                    return $this->createCheckResultArray(
                        $result,
                        $result ? $rule->passedMessage : $rule->failedMessage,
                        $rule->helpMessage,
                        $rule->level()
                    );
                } catch (Exception $e) {
                    $this->logger->critical($e->getMessage());

                    return $this->createCheckResultArray(
                        false,
                        $this->markdown->parse(sprintf('Error checking rule `%s`.', get_class($rule))),
                        config('app.debug') ? (string) $e->getMessage() : null,
                        Levels::ERROR
                    );
                }
            })
            ->all();
    }

    private function createCheckResultArray(
        bool $result,
        string $resultMessage,
        string $helpMessage,
        string $errorLevel
    ): array {
        return [
            'passed' => $result,
            'message' => $resultMessage,
            'help' => $helpMessage,
            'level' => $errorLevel,
        ];
    }
}
