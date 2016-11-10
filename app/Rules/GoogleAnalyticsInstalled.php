<?php

namespace App\Rules;

use App\Crawler;

class GoogleAnalyticsInstalled extends Rule
{
    private $gaCode;

    /**
     * @inheritdoc
     * @throws \RuntimeException
     */
    public function check(Crawler $crawler = null, $url = null)
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

    /**
     * @inheritdoc
     */
    public function passedMessage()
    {
        return "Google Analytics code found (account # `{$this->gaCode}`)";
    }

    /**
     * @inheritdoc
     */
    public function failedMessage()
    {
        return 'Google Analytics code not found';
    }
}
