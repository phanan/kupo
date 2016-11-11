<?php

namespace App\Rules;

class MetaDescriptionExists extends Rule
{
    private $description;

    /**
     * {@inheritdoc}
     */
    public function check()
    {
        if (count($tags = $this->crawler->filter('meta[name=description]'))) {
            $this->description = trim($tags->first()->attr('content'));
        }

        return (bool) $this->description;
    }

    /**
     * {@inheritdoc}
     */
    public function passedMessage()
    {
        return "Meta description found: `{$this->description}`.";
    }

    /**
     * {@inheritdoc}
     */
    public function failedMessage()
    {
        return 'Meta description not found or empty.';
    }

    /**
     * {@inheritdoc}
     */
    public function helpMessage()
    {
        return <<<MSG
A meta description summarizes a page content and is often used by search engines to display as a snippet in search results. You can learn how to create the right meta description [here](https://yoast.com/meta-descriptions/), kupo!  
MSG;
    }

    public function getDescription()
    {
        return $this->description;
    }
}
