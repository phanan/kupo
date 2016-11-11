<?php

use App\Rules\RobotsAllowedInMetaTag;

class RobotsAllowedInMetaTagTest extends TestCase
{
    public function testCheck()
    {
        $crawler = $this->createCrawlerFromBlob('RobotsAllowedInMetaTagPassed');
        $rule = new RobotsAllowedInMetaTag($crawler);
        static::assertTrue($rule->check());

        $crawler = $this->createCrawlerFromBlob('RobotsAllowedInMetaTagFailed');
        $rule = new RobotsAllowedInMetaTag($crawler);
        static::assertFalse($rule->check());
    }
}
