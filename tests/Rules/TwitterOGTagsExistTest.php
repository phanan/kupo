<?php

namespace Tests\Rules;

use App\Rules\TwitterOGTagsExist;
use Tests\BrowserKitTestCase;

class TwitterOGTagsExistTest extends BrowserKitTestCase
{
    public function testCheck()
    {
        $crawler = $this->createCrawlerFromBlob('TwitterOGTagsExistPassed');
        $rule = new TwitterOGTagsExist($crawler);
        static::assertTrue($rule->check());

        $crawler = $this->createCrawlerFromBlob('TwitterOGTagsExistFailed');
        $rule = new TwitterOGTagsExist($crawler);
        static::assertFalse($rule->check());
    }
}
