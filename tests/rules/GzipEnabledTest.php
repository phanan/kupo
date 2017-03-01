<?php

namespace Tests\Rules;

use App\Rules\GzipEnabled;
use Tests\BrowserKitTestCase;

class GzipEnabledTest extends BrowserKitTestCase
{
    public function testCheckGzipped()
    {
        $rule = new GzipEnabled();

        $args = $this->createArgumentsFromMessage('GzippedResponse');
        static::assertTrue($rule->check(...$args));
    }

    public function testCheckNotGzipped()
    {
        $rule = new GzipEnabled();

        $args = $this->createArgumentsFromMessage('PlainResponse');
        static::assertFalse($rule->check(...$args));
    }
}
