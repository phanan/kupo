<?php

use App\Rules\TwitterOGTagsExist;

class TwitterOGTagsExistTest extends TestCase
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
