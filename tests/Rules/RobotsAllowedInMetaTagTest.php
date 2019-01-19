<?php

namespace Tests\Rules;

use App\Rules\RobotsAllowedInMetaTag;
use Tests\TestCase;

class RobotsAllowedInMetaTagTest extends TestCase
{
    use RuleTestTrait;

    public function provideCheckData(): array
    {
        return [['RobotsAllowedInMetaTagPassed', true], ['RobotsAllowedInMetaTagFailed', false]];
    }

    /** @dataProvider provideCheckData */
    public function testCheck(string $blobFileName, bool $expectedResult): void
    {
        $this->assertSame($expectedResult, $this->rule->check(...$this->createArgumentsFromBlob($blobFileName)));
    }

    protected function getRuleClass(): string
    {
        return RobotsAllowedInMetaTag::class;
    }
}
