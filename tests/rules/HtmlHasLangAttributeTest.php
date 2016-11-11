<?php

use App\Rules\HtmlHasLangAttribute;

class HtmlHasLangAttributeTest extends TestCase
{
    public function testCheck()
    {
        $crawler = $this->createCrawlerFromBlob('HtmlHasLangAttributePassed');
        $rule = new HtmlHasLangAttribute($crawler);
        static::assertTrue($rule->check());
        static::assertEquals('vi', $rule->getLang());

        $crawler = $this->createCrawlerFromBlob('HtmlHasLangAttributeFailed');
        $rule = new HtmlHasLangAttribute($crawler);
        static::assertFalse($rule->check());
    }
}
