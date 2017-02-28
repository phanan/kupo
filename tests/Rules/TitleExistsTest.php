<?php

namespace Tests\Rules;

use App\Rules\TitleExists;
use Tests\BrowserKitTestCase;

class TitleExistsTest extends BrowserKitTestCase
{
    public function testCheck()
    {
        $args = $this->createArgumentsFromBlob('TitleExistsPassed');
        $rule = new TitleExists();
        static::assertTrue($rule->check(...$args));
        static::assertEquals('Foo', $rule->getTitle());

        $args = $this->createArgumentsFromBlob('TitleExistsFailed');
        $rule = new TitleExists();
        static::assertFalse($rule->check(...$args));
    }
}
