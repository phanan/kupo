<?php

namespace Tests\Rules;

use App\Rules\HtmlHasLangAttribute;
use Tests\BrowserKitTestCase;

class HtmlHasLangAttributeTest extends BrowserKitTestCase
{
    public function testCheck()
    {
        $args = $this->createArgumentsFromBlob('HtmlHasLangAttributePassed');
        $rule = new HtmlHasLangAttribute();
        static::assertTrue($rule->check(...$args));
        static::assertEquals('vi', $rule->getLang());

        $args = $this->createArgumentsFromBlob('HtmlHasLangAttributeFailed');
        $rule = new HtmlHasLangAttribute();
        static::assertFalse($rule->check(...$args));
    }
}
