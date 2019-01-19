<?php

namespace App\Rules;

use App\Crawler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class GoogleAnalyticsInstalled extends Rule
{
    private $gaCode;

    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri): bool
    {
        foreach ($crawler->filter('script') as $script) {
            $html = $script->ownerDocument->saveHTML($script);

            if (preg_match('/(ua-\d{4,9}-\d{1,4})/i', $html, $matches)) {
                $this->gaCode = $matches[1];
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
        return <<<MSG
As [Google Analytics](https://analytics.google.com) is arguably the most popular web analytics service, it’s assumed here that you want to integrate your site with a GA account. Of course you can safely ignore this rule if it isn’t the case, kupo!
MSG;
    }

    public function getGaCode(): ?string
    {
        return $this->gaCode;
    }
}
