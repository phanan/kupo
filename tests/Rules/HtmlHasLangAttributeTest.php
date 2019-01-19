<?php

namespace Tests\Rules;

use App\Rules\HtmlHasLangAttribute;
use Tests\TestCase;

class HtmlHasLangAttributeTest extends TestCase
{
    use RuleTestTrait;

    public function provideCheckData(): array
    {
        return [['HtmlHasLangAttributePassed', true, 'vi'], ['HtmlHasLangAttributeFailed', false, null]];
    }

    /** @dataProvider provideCheckData */
    public function testCheck(string $blobFileName, bool $expectedResult, ?string $expectedLang): void
    {
        $this->assertSame($expectedResult, $this->rule->check(...$this->createArgumentsFromBlob($blobFileName)));
        $this->assertSame($expectedLang, $this->rule->getLang());
    }

    protected function getRuleClass(): string
    {
        return HtmlHasLangAttribute::class;
    }
}
