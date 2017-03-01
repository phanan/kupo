<?php

namespace Tests\Rules;

use App\Rules\FacebookOGTagsExist;
use Tests\BrowserKitTestCase;

class FacebookOGTagsExistTest extends BrowserKitTestCase
{
    public function testCheck()
    {
        $args = $this->createArgumentsFromBlob('FacebookOGTagsExistPassed');
        $rule = new FacebookOGTagsExist();
        static::assertTrue($rule->check(...$args));

        $args = $this->createArgumentsFromBlob('FacebookOGTagsExistFailed');
        $rule = new FacebookOGTagsExist();
        static::assertFalse($rule->check(...$args));
    }
}
