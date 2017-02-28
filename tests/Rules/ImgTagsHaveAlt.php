<?php

namespace Tests\Rules;

use App\Rules\ImgTagsHaveAlt;
use Tests\BrowserKitTestCase;

class ImgTagsHaveAlt extends BrowserKitTestCase
{
    public function testCheck()
    {
        $crawler = $this->createCrawlerFromBlob('ImgTagsHaveAltPassed');
        $rule = new self($crawler);
        static::assertTrue($rule->check());

        $crawler = $this->createCrawlerFromBlob('ImgTagsHaveAltFailed');
        $rule = new self($crawler);
        static::assertFalse($rule->check());
    }
}
