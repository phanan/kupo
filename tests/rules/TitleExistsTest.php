<?php

namespace Tests\Rules;

use App\Rules\TitleExists;
use Tests\BrowserKitTestCase;

class TitleExistsTest extends BrowserKitTestCase
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
