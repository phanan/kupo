<?php

namespace Tests\Rules;

use App\Rules\ImgTagsHaveAlt;
use Tests\BrowserKitTestCase;

class ImgTagsHaveAltTest extends BrowserKitTestCase
{
    public function testCheck()
    {
        $args = $this->createArgumentsFromBlob('ImgTagsHaveAltPassed');
        $rule = new ImgTagsHaveAlt();
        static::assertTrue($rule->check(...$args));

        $args = $this->createArgumentsFromBlob('ImgTagsHaveAltFailed');
        $rule = new ImgTagsHaveAlt();
        static::assertFalse($rule->check(...$args));
    }
}
