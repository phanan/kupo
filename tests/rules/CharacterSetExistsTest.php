<?php

namespace Tests\Rules;

use App\Rules\CharacterSetExists;
use Tests\BrowserKitTestCase;

class CharacterSetExistsTest extends BrowserKitTestCase
{
    public function testCheckHTML5()
    {
        $args = $this->createArgumentsFromBlob('CharacterSetExistsPassed_HTML5');
        $rule = new CharacterSetExists();
        static::assertTrue($rule->check(...$args));
        static::assertEquals('UTF-8', $rule->getCharset());
    }

    public function testCheckHTML4()
    {
        $args = $this->createArgumentsFromBlob('CharacterSetExistsPassed_HTML4');
        $rule = new CharacterSetExists();
        static::assertTrue($rule->check(...$args));
        static::assertEquals('ISO-8859-1', $rule->getCharset());
    }

    public function testFail()
    {
        $args = $this->createArgumentsFromBlob('CharacterSetExistsFailed');
        $rule = new CharacterSetExists();
        static::assertFalse($rule->check(...$args));
    }
}
