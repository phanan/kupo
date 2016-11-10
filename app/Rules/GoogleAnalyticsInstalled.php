<?php

namespace App\Rules;

class GoogleAnalyticsInstalled extends Rule
{
    private $gaCode;

    /**
     * @inheritdoc
     */
    public function check()
    {
        foreach ($this->crawler->filter('script') as $script) {
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
