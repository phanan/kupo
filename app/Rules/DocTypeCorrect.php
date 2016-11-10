<?php

namespace App\Rules;

class DocTypeCorrect extends Rule
{
    private $docType;

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function check()
    {
        if (preg_match('/^<!doctype\s.*?>/i', trim($this->crawler->getRaw()), $matches)) {
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

    public function getDocType()
    {
        return $this->docType;
    }
}
