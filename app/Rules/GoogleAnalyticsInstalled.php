<?php

namespace App\Rules;

use App\Crawler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class GoogleAnalyticsInstalled extends Rule
{
    private const GA_REGEX = '/(ua-\d{4,9}-\d{1,4})|(ua\\\u002d\d{4,9}\\\u002d\d{1,4})/i';

    private $gaCode;

    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri): bool
    {
        foreach ($crawler->filter('script') as $script) {
            $html = $script->ownerDocument->saveHTML($script);

            if (preg_match(self::GA_REGEX, $html, $matches)) {
                $this->gaCode = $matches[0];
                break;
            }
        }

        return (bool) $this->gaCode;
    }

    public function passedMessage(): string
    {
        return "Google Analytics code found (account # `{$this->gaCode}`).";
    }

    public function failedMessage(): string
    {
        return 'Google Analytics code not found.';
    }

    public function helpMessage(): string
    {
        return <<<'MSG'
As [Google Analytics](https://analytics.google.com) is arguably the most popular web analytics service, it’s assumed here that you want to integrate your site with a GA account. Of course you can safely ignore this rule if it isn’t the case, kupo!
MSG;
    }

    public function getGaCode(): ?string
    {
        return $this->gaCode;
    }
}
