<?php

use App\Rules\MetaDescriptionExists;

class MetaDescriptionExistsTest extends TestCase
{
    public function testCheck()
    {
        $crawler = $this->createCrawlerFromBlob('MetaDescriptionExistsPassed');
        $rule = new MetaDescriptionExists($crawler);
        static::assertTrue($rule->check());
        static::assertEquals('A foo walks into a bar.', $rule->getDescription());

        $crawler = $this->createCrawlerFromBlob('MetaDescriptionExistsFailed');
        $rule = new MetaDescriptionExists($crawler);
        static::assertFalse($rule->check());
    }
}
