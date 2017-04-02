<?php

namespace App\Services;

use App\Rules\Levels;
use Exception;
use GuzzleHttp\Psr7\Uri;
use PhpInsights\InsightsCaller;
use PhpInsights\Result\Map\FormattedResults\DefaultRuleResult;

class Insights
{
    /** @var InsightsCaller */
    private $insightsCaller;

    /**
     * Construct a new instance of this service.
     *
     * @param InsightsCaller $insightsCaller
     */
    public function __construct(InsightsCaller $insightsCaller)
    {
        $this->insightsCaller = $insightsCaller;
    }

    /**
     * Validate the URL against our checklist.
     *
     * @param string|null $url
     * @param string      $strategy
     *
     * @throws Exception
     *
     * @return \Generator
     */
    public function validate($url, $strategy = InsightsCaller::STRATEGY_MOBILE)
    {
        $uri = new Uri($url);

        $response = $this->insightsCaller->getResponse((string) $uri, $strategy);
        $result = $response->getMappedResult();

        yield [
            // If the rule impact is zero, it means that the website has passed the test.
            'passed' => (bool) $result->screenshot,
            'message' => $result->screenshot->getImageHtml(),
            'help' => null,
            'level' => Levels::NOTICE,
        ];

        if ($strategy == InsightsCaller::STRATEGY_MOBILE) {
            yield [
                // If the rule impact is zero, it means that the website has passed the test.
                'passed' => $result->getSpeedScore() >= 80,
                'message' => 'Your Google Page Insights Mobile Pagespeed score is: <b>'.$result->getSpeedScore().'</b>',
                'help' => null,
                'level' => $this->getLevel(100 - $result->getSpeedScore()),
            ];

            yield [
                // If the rule impact is zero, it means that the website has passed the test.
                'passed' => $result->getUsabilityScore() >= 80,
                'message' => 'Your Google Page Insights Mobile Usability score is: <b>'.$result->getUsabilityScore().'</b>',
                'help' => null,
                'level' => $this->getLevel(100 - $result->getUsabilityScore()),
            ];
        } else {
            yield [
                // If the rule impact is zero, it means that the website has passed the test.
                'passed' => $result->getSpeedScore() >= 80,
                'message' => 'Your Google Page Insights Desktop Pagespeed score is: <b>'.$result->getSpeedScore().'</b>',
                'help' => null,
                'level' => $this->getLevel(100 - $result->getSpeedScore()),
            ];
        }

        $results = collect($result->getFormattedResults()->getRuleResults())
            ->sortByDesc(function (DefaultRuleResult $result) {
                return $result->getRuleImpact();
            });

        /** @var DefaultRuleResult $ruleResult */
        foreach ($results as $rule => $ruleResult) {
            $help = [];
            if ($urlBlocks = $ruleResult->getUrlBlocks()) {
                foreach ($ruleResult->getDetails() as $detail) {
                    if ($detail) {
                        $help[] = $detail->toString();
                    }
                }
            }

            yield [
                // If the rule impact is zero, it means that the website has passed the test.
                'passed' => $ruleResult->getRuleImpact() == 0,
                'message' => $ruleResult->getSummary()->toString() ?: $rule,
                'help' => $help ? implode('<br/>', $help) : null,
                'level' => $this->getLevel($ruleResult->getRuleImpact()),
            ];
        }
    }

    protected function getLevel($impact)
    {
        if ($impact < 3) {
            return Levels::NOTICE;
        } elseif ($impact < 20) {
            return Levels::WARNING;
        } elseif ($impact < 50) {
            return Levels::WARNING;
        } else {
            return Levels::CRITICAL;
        }
    }
}
