<?php

namespace App\Rules;

use App\Crawler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class MetaDescriptionExists extends Rule
{
    private $description;

    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri): bool
    {
        if (count($tags = $crawler->filterCaseInsensitiveAttribute('meta[name=description]'))) {
            $this->description = trim($tags->first()->attr('content'));
        }

        return (bool) $this->description;
    }

    public function passedMessage(): string
    {
        return "Meta description found: `{$this->description}`.";
    }

    public function failedMessage(): string
    {
        return 'Meta description not found or empty.';
    }

    public function helpMessage(): string
    {
        return <<<'MSG'
A meta description summarizes a page content and is often used by search engines to display as a snippet in search results. You can learn how to create the right meta description [here](https://yoast.com/meta-descriptions/), kupo!  
MSG;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }
}
