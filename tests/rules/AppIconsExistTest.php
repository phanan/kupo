<?php

namespace Tests\Rules;

use App\Rules\AppIconsExist;
use Tests\BrowserKitTestCase;

class AppIconsExistTest extends BrowserKitTestCase
{
    public function testCheck()
    {
        $rule = new AppIconsExist();

        $args = $this->createArgumentsFromBlob('AppIconsExistPassed');
        static::assertTrue($rule->check(...$args));

        $args = $this->createArgumentsFromBlob('AppIconsExistFailed');
        static::assertFalse($rule->check(...$args));
    }
}
