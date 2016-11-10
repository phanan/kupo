<?php

namespace App\Rules;

use App\Crawler;

class DocTypeCorrect extends Rule
{
    private $docType;

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function check(Crawler $crawler = null, $url = null)
    {
        if (preg_match('/^<!doctype\s.*?>/i', trim($crawler->getRaw()), $matches)) {
            $this->docType = trim($matches[0]);
        }

        return (bool) $this->docType;
    }

    /**
     * @inheritdoc
     */
    public function passedMessage()
    {
        return "Doc type found: `{$this->docType}`";
    }

    /**
     * @inheritdoc
     */
    public function failedMessage()
    {
        return 'Doc type not found';
    }
}
