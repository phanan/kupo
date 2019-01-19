<?php

namespace App\Rules;

use App\Crawler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class HtmlHasLangAttribute extends Rule
{
    private $lang;

    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri): bool
    {
        $this->lang = $crawler->attr('lang');

        return (bool) $this->lang;
    }

    public function level(): string
    {
        return Levels::NOTICE;
    }

    public function passedMessage(): string
    {
        return "`<html>` tag has a `lang` attribute (`$this->lang`).";
    }

    public function failedMessage(): string
    {
        return '`<html>` tag should have an explicit `lang` attribute.';
    }

    public function helpMessage(): string
    {
        return <<<MSG
A `lang` attribute in the `<html>` tag sets the language for all the text on the page, which is [a good thing to do](https://www.w3.org/International/questions/qa-lang-why.en), kupo! 
MSG;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }
}
