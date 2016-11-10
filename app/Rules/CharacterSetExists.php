<?php

namespace App\Rules;

use App\Crawler;

class CharacterSetExists extends Rule
{
    private $charset;

    /**
     * @inheritdoc
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function check(Crawler $crawler = null, $url = null)
    {
        if (count($tags = $crawler->filter('meta[charset]'))) {
            // <meta charset="utf-8">
            $this->charset = trim($tags->first()->attr('charset'));
        } elseif (count($tags = $crawler->filter('meta[http-equiv="Content-Type"]'))) {
            // <meta http-equiv="Content-Type" content="text/html; utf-8">
            $value = $tags->first()->attr('content');
            if (preg_match('/charset\s*=\s*(.*)/i', $value, $matches)) {
                $this->charset = trim($matches[1]);
            }
        }

        return (bool) $this->charset;
    }

    /**
     * @inheritdoc
     */
    public function passedMessage()
    {
        return "Character set found: `{$this->charset}`";
    }

    /**
     * @inheritdoc
     */
    public function failedMessage()
    {
        return 'Character set not found';
    }
}
