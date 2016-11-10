<?php

namespace App\Rules;

class MetaDescriptionExists extends Rule
{
    private $description;

    /**
     * @inheritdoc
     */
    public function check()
    {
        if (count($tags = $this->crawler->filter('meta[name=description]'))) {
            $this->description = trim($tags->first()->attr('content'));
        }

        return (bool) $this->description;
    }

    /**
     * @inheritdoc
     */
    public function passedMessage()
    {
        return "Meta description found: `{$this->description}`";
    }

    /**
     * @inheritdoc
     */
    public function failedMessage()
    {
        return 'Meta description not found or empty';
    }
}
