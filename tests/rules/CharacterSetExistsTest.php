<?php

namespace Tests\Rules;

use App\Rules\CharacterSetExists;
use Tests\BrowserKitTestCase;

class CharacterSetExistsTest extends BrowserKitTestCase
{
    public function testCheckHTML5()
    {
        $crawler = $this->createCrawlerFromBlob('CharacterSetExistsPassed_HTML5');
        $rule = new CharacterSetExists($crawler);
        static::assertTrue($rule->check());
        static::assertEquals('UTF-8', $rule->getCharset());
    }

    public function testCheckHTML4()
    {
        $crawler = $this->createCrawlerFromBlob('CharacterSetExistsPassed_HTML4');
        $rule = new CharacterSetExists($crawler);
        static::assertTrue($rule->check());
        static::assertEquals('ISO-8859-1', $rule->getCharset());
    }

    public function testFail()
    {
        $crawler = $this->createCrawlerFromBlob('CharacterSetExistsFailed');
        $rule = new CharacterSetExists($crawler);
        static::assertFalse($rule->check());
    }
}
