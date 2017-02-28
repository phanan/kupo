<?php

namespace Tests\Rules;

use App\Rules\ImgTagsHaveAlt;
use Tests\BrowserKitTestCase;

class ImgTagsHaveAlt extends BrowserKitTestCase
{
    public function testCheck()
    {
        $args = $this->createArgumentsFromBlob('ImgTagsHaveAltPassed');
        $rule = new self();
        static::assertTrue($rule->check(...$args));

        $args = $this->createArgumentsFromBlob('ImgTagsHaveAltFailed');
        $rule = new self();
        static::assertFalse($rule->check(...$args));
    }
}
