<?php

namespace App\Rules;

use App\Crawler;

class TitleExists extends Rule
{
    private $title;

    /**
     * @inheritdoc
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function check(Crawler $crawler = null, $url = null)
    {
        if (count($tags = $crawler->filter('title'))) {
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
}
