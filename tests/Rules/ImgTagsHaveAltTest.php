<?php

namespace Tests\Rules;

use App\Rules\ImgTagsHaveAlt;
use Tests\TestCase;

class ImgTagsHaveAltTest extends TestCase
{
    use RuleTestTrait;

    public function provideCheckData(): array
    {
        return [['ImgTagsHaveAltPassed', true], ['ImgTagsHaveAltFailed', false]];
    }

    /** @dataProvider provideCheckData */
    public function testCheck(string $blobFileName, bool $expectedResult): void
    {
        $this->assertSame($expectedResult, $this->rule->check(...$this->createArgumentsFromBlob($blobFileName)));
    }

    protected function getRuleClass(): string
    {
        return ImgTagsHaveAlt::class;
    }
}
