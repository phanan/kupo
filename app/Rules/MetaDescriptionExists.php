<?php

namespace App\Rules;

use App\Crawler;

class MetaDescriptionExists extends Rule
{
    private $description;

    /**
     * @inheritdoc
     * @throws \InvalidArgumentException
     * @throws \RuntimeException
     */
    public function check(Crawler $crawler = null, $url = null)
    {
        if (count($tags = $crawler->filter('meta[name=description]'))) {
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
