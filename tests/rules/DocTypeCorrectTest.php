<?php

namespace Tests\Rules;

use App\Rules\DocTypeCorrect;
use Tests\BrowserKitTestCase;

class DocTypeCorrectTest extends BrowserKitTestCase
{
    public function testCheck()
    {
        $crawler = $this->createCrawlerFromBlob('DocTypeCorrectPassed');
        $rule = new DocTypeCorrect($crawler);
        static::assertTrue($rule->check());
        static::assertEquals('<!DOCTYPE html>', $rule->getDocType());

        $crawler = $this->createCrawlerFromBlob('DocTypeCorrectFailed');
        $rule = new DocTypeCorrect($crawler);
        static::assertFalse($rule->check());
    }
}
