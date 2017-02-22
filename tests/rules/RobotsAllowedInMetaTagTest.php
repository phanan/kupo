<?php

namespace Tests\Rules;

use App\Rules\RobotsAllowedInMetaTag;
use Tests\BrowserKitTestCase;

class RobotsAllowedInMetaTagTest extends BrowserKitTestCase
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
