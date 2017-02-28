<?php

namespace Tests\Rules;

use App\Rules\DocTypeCorrect;
use Tests\BrowserKitTestCase;

class DocTypeCorrectTest extends BrowserKitTestCase
{
    public function testCheck()
    {
        $args = $this->createArgumentsFromBlob('DocTypeCorrectPassed');
        $rule = new DocTypeCorrect();
        static::assertTrue($rule->check(...$args));
        static::assertEquals('<!DOCTYPE html>', $rule->getDocType());

        $args = $this->createArgumentsFromBlob('DocTypeCorrectFailed');
        $rule = new DocTypeCorrect();
        static::assertFalse($rule->check(...$args));
    }
}
