<?php

namespace App\Rules;

class HtmlHasLangAttribute extends Rule
{
    private $lang;

    /**
     * @inheritdoc
     */
    public function check()
    {
        $this->lang = trim($this->crawler->attr('lang'));

        return (bool) $this->lang;
    }

    /**
     * @inheritdoc
     */
    public function level()
    {
        return Levels::NOTICE;
    }

    /**
     * @inheritdoc
     */
    public function passedMessage()
    {
        return "`<html>` tag has a `lang` attribute (`$this->lang`)";
    }

    /**
     * @inheritdoc
     */
    public function failedMessage()
    {
        return '`<html>` tag should explicitly have a `lang` attribute';
    }
}
