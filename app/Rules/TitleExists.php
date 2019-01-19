<?php

namespace App\Rules;

use App\Crawler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class TitleExists extends Rule
{
    private $title;

    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri): bool
    {
        if (count($tags = $crawler->filter('title'))) {
            $this->title = trim($tags->first()->text());
        }

        return (bool) $this->title;
    }

    public function passedMessage(): string
    {
        return "Title found: `{$this->title}`.";
    }

    public function failedMessage(): string
    {
        return 'Title not found or empty.';
    }

    public function helpMessage(): string
    {
        return <<<MSG
Unless he has his own submarine, a person should have a name. Likewise, a web page should have a title, kupo!  
MSG;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }
}
