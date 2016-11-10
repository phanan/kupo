<?php

namespace App\Rules;

use App\Crawler;

class Rule implements RuleInterface
{

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function check(Crawler $crawler = null, $url = null)
    {
        throw new \Exception('Unimplemented method.');
    }

    /**
     * @inheritdoc
     */
    public function level()
    {
        return Levels::WARNING;
    }

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function passedMessage()
    {
        throw new \Exception('Unimplemented method.');
    }

    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function failedMessage()
    {
        throw new \Exception('Unimplemented method.');
    }

    public function __get($name)
    {
        if ($name === 'passedMessage' || $name === 'failedMessage') {
            return md($this->$name());
        }

        return $this->$name;
    }
}
