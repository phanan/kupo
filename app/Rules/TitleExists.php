<?php

namespace App\Rules;

class TitleExists extends Rule
{
    private $title;

    /**
     * @inheritdoc
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function check()
    {
        if (count($tags = $this->crawler->filter('title'))) {
            $this->title = trim($tags->first()->text());
        }

        return (bool) $this->title;
    }

    /**
     * @inheritdoc
     */
    public function passedMessage()
    {
        return "Title found: `{$this->title}`";
    }

    /**
     * @inheritdoc
     */
    public function failedMessage()
    {
        return 'Title not found or empty';
    }

    public function getTitle()
    {
        return $this->title;
    }
}
