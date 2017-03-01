<?php

namespace App\Rules;

use App\Crawler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class DocTypeCorrect extends Rule
{
    private $docType;

    /**
     * {@inheritdoc}
     *
     * @throws \Exception
     */
    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri)
    {
        if (preg_match('/^<!doctype\s.*?>/i', trim($response->getBody()), $matches)) {
            $this->docType = trim($matches[0]);
        }

        return (bool) $this->docType;
    }

    /**
     * {@inheritdoc}
     */
    public function passedMessage()
    {
        return "Doc type found: `{$this->docType}`.";
    }

    /**
     * {@inheritdoc}
     */
    public function failedMessage()
    {
        return 'Doc type not found.';
    }

    /**
     * {@inheritdoc}
     */
    public function helpMessage()
    {
        return <<<'MSG'
A Doctype, or DOCTYPE, helps the HTML layout engines determine a layout mode, such as “[quirks mode](https://en.wikipedia.org/wiki/Quirks_mode)” or “standard mode.” For HTML5, a simple `<!DOCTYPE html>` declaration on top of your page should suffice, kupo!  
MSG;
    }

    public function getDocType()
    {
        return $this->docType;
    }
}
