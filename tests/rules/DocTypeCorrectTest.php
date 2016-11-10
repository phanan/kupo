<?php

use App\Rules\DocTypeCorrect;

class DocTypeCorrectTest extends TestCase
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
