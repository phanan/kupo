<?php

namespace App\Rules;

class TitleExists extends Rule
{
    private $title;

    /**
     * {@inheritdoc}
     *
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
     * {@inheritdoc}
     */
    public function passedMessage()
    {
        return "Title found: `{$this->title}`.";
    }

    /**
     * {@inheritdoc}
     */
    public function failedMessage()
    {
        return 'Title not found or empty.';
    }

    /**
     * {@inheritdoc}
     */
    public function helpMessage()
    {
        return <<<'MSG'
Unless he has his own submarine, a person should have a name. Likewise, a web page should have a title, kupo!  
MSG;
    }

    public function getTitle()
    {
        return $this->title;
    }
}
