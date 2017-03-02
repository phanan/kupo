<?php

namespace App\Rules;

use App\Crawler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class HtmlHasLangAttribute extends Rule
{
    private $lang;

    /**
     * {@inheritdoc}
     */
    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri)
    {
        $this->lang = trim($crawler->attr('lang'));

        return (bool) $this->lang;
    }

    /**
     * {@inheritdoc}
     */
    public function level()
    {
        return Levels::NOTICE;
    }

    /**
     * {@inheritdoc}
     */
    public function passedMessage()
    {
        return "`<html>` tag has a `lang` attribute (`$this->lang`).";
    }

    /**
     * {@inheritdoc}
     */
    public function failedMessage()
    {
        return '`<html>` tag should have an explicit `lang` attribute.';
    }

    /**
     * {@inheritdoc}
     */
    public function helpMessage()
    {
        return <<<'MSG'
A `lang` attribute in the `<html>` tag sets the language for all the text on the page, which is [a good thing to do](https://www.w3.org/International/questions/qa-lang-why.en), kupo! 
MSG;
    }

    public function getLang()
    {
        return $this->lang;
    }
}
