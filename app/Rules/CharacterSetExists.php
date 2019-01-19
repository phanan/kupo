<?php

namespace App\Rules;

use App\Crawler;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class CharacterSetExists extends Rule
{
    private $charset;

    /** @throws Exception */
    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri): bool
    {
        if (count($tags = $crawler->filter('meta[charset]'))) {
            // <meta charset="utf-8">
            $this->charset = trim($tags->first()->attr('charset'));
        } elseif (count($tags = $crawler->filterCaseInsensitiveAttribute('meta[http-equiv=content-type]'))) {
            // <meta http-equiv="Content-Type" content="text/html; utf-8">
            $value = $tags->first()->attr('content');

            if (preg_match('/charset\s*=\s*(.*)/i', $value, $matches)) {
                $this->charset = trim($matches[1]);
            }
        }

        return (bool) $this->charset;
    }

    public function passedMessage(): string
    {
        return "Character set found: `{$this->charset}`.";
    }

    public function failedMessage(): string
    {
        return 'Character set not found.';
    }

    public function getCharset(): ?string
    {
        return $this->charset;
    }

    public function helpMessage(): string
    {
        return <<<MSG
A valid [character set](https://en.wikipedia.org/wiki/Character_encodings_in_HTML) helps browsers display a page correctly.
Most of the time you’ll want a `UTF-8` encoding. For HTML5, all you need is a `<meta charset="UTF-8">` tag in `<head>`, kupo!
MSG;
    }
}
