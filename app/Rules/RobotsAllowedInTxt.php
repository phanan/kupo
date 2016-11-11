<?php

namespace App\Rules;

use App\Facades\RobotsFile;

class RobotsAllowedInTxt extends Rule
{
    /**
     * {@inheritdoc}
     */
    public function check()
    {
        if (!$content = RobotsFile::getContent()) {
            return true;
        }

        // To simplify our case, only check if
        //   User-agent: *
        //   Disallow: /
        // appears in the file.

        $parser = RobotsFile::getParser();
        $parser->setUserAgent('*');

        return $parser->isAllowed('/');
    }

    /**
     * {@inheritdoc}
     */
    public function level()
    {
        return Levels::CRITICAL;
    }

    /**
     * {@inheritdoc}
     */
    public function passedMessage()
    {
        return 'Search engines are not banned by `robots.txt`.';
    }

    /**
     * {@inheritdoc}
     */
    public function failedMessage()
    {
        return 'Search engines are banned by `robots.txt`.';
    }

    /**
     * {@inheritdoc}
     */
    public function helpMessage()
    {
        return <<<MSG
A site can also specify crawling instructions in a file named [`robots.txt`](http://www.robotstxt.org/robotstxt.html), placed at the root of its public directory. Having 
```
User-agent: *
Disallow: /
``` 
in this file essentially tells search engines to NOT visit (and index) any page on the site, kupo!
MSG;
    }
}
