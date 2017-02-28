<?php

namespace Tests\Rules;

use App\Rules\FacebookOGTagsExist;
use Tests\BrowserKitTestCase;

class FacebookOGTagsExistTest extends BrowserKitTestCase
{
    public function testCheck()
    {
        $crawler = $this->createCrawlerFromBlob('FacebookOGTagsExistPassed');
        $rule = new FacebookOGTagsExist($crawler);
        static::assertTrue($rule->check());

        $crawler = $this->createCrawlerFromBlob('FacebookOGTagsExistFailed');
        $rule = new FacebookOGTagsExist($crawler);
        static::assertFalse($rule->check());
    }
}
