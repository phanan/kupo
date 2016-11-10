<?php

use App\Rules\TitleExists;

class TitleExistsTest extends TestCase
{
    public function testCheck()
    {
        $crawler = $this->createCrawlerFromBlob('TitleExistsPassed');
        $rule = new TitleExists($crawler);
        static::assertTrue($rule->check());
        static::assertEquals('Foo', $rule->getTitle());

        $crawler = $this->createCrawlerFromBlob('TitleExistsFailed');
        $rule = new TitleExists($crawler);
        static::assertFalse($rule->check());
    }
}
