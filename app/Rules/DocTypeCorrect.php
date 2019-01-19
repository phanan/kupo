<?php

namespace App\Rules;

use App\Crawler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class DocTypeCorrect extends Rule
{
    private $docType;

    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri): bool
    {
        if (preg_match('/^<!doctype\s.*?>/i', $response->getBody(), $matches)) {
            $this->docType = trim($matches[0]);
        }

        return (bool) $this->docType;
    }

    public function passedMessage(): string
    {
        return "Doc type found: `{$this->docType}`.";
    }

    public function failedMessage(): string
    {
        return 'Doc type not found.';
    }

    public function helpMessage(): string
    {
        return <<<'MSG'
A Doctype, or DOCTYPE, helps the HTML layout engines determine a layout mode, such as “[quirks mode](https://en.wikipedia.org/wiki/Quirks_mode)” or “standard mode.” For HTML5, a simple `<!DOCTYPE html>` declaration on top of your page should suffice, kupo!  
MSG;
    }

    public function getDocType(): ?string
    {
        return $this->docType;
    }
}
