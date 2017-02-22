<?php

namespace App\Rules;

class HtmlHasLangAttribute extends Rule
{
    private $lang;

    /**
     * {@inheritdoc}
     */
    public function check()
    {
        $this->lang = trim($this->crawler->attr('lang'));

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
