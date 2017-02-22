<?php

namespace Tests\Rules;

use App\Rules\MetaDescriptionExists;
use Tests\BrowserKitTestCase;

class MetaDescriptionExistsTest extends BrowserKitTestCase
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
