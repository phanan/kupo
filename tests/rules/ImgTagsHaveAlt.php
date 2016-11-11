<?php

use App\Rules\ImgTagsHaveAlt;

class ImgTagsHaveAltTest extends TestCase
{
    public function testCheck()
    {
        $crawler = $this->createCrawlerFromBlob('ImgTagsHaveAltPassed');
        $rule = new ImgTagsHaveAlt($crawler);
        static::assertTrue($rule->check());

        $crawler = $this->createCrawlerFromBlob('ImgTagsHaveAltFailed');
        $rule = new ImgTagsHaveAlt($crawler);
        static::assertFalse($rule->check());
    }
}
