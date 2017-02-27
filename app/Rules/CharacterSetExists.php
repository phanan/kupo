<?php

namespace App\Rules;

class CharacterSetExists extends Rule
{
    private $charset;

    /**
     * {@inheritdoc}
     */
    public function check()
    {
        if (count($tags = $this->crawler->filter('meta[charset]'))) {
            // <meta charset="utf-8">
            $this->charset = trim($tags->first()->attr('charset'));
        } elseif (count($tags = $this->crawler->filterCaseInsensitiveAttribute('meta[http-equiv=content-type]'))) {
            // <meta http-equiv="Content-Type" content="text/html; utf-8">
            $value = $tags->first()->attr('content');
            if (preg_match('/charset\s*=\s*(.*)/i', $value, $matches)) {
                $this->charset = trim($matches[1]);
            }
        }

        return (bool) $this->charset;
    }

    /**
     * {@inheritdoc}
     */
    public function passedMessage()
    {
        return "Character set found: `{$this->charset}`.";
    }

    /**
     * {@inheritdoc}
     */
    public function failedMessage()
    {
        return 'Character set not found.';
    }

    public function getCharset()
    {
        return $this->charset;
    }

    /**
     * {@inheritdoc}
     */
    public function helpMessage()
    {
        return <<<'MSG'
A valid [character set](https://en.wikipedia.org/wiki/Character_encodings_in_HTML) helps browsers display a page correctly.
Most of the time you’ll want a `UTF-8` encoding. For HTML5, all you need is a `<meta charset="UTF-8">` tag in `<head>`, kupo!
MSG;
    }
}
