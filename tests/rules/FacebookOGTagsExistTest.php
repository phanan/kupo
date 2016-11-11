<?php

use App\Rules\FacebookOGTagsExist;

class FacebookOGTagsExistTest extends TestCase
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
