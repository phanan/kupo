<?php

namespace Tests\Rules;

use App\Rules\AppIconsExist;
use Tests\TestCase;

class AppIconsExistTest extends TestCase
{
    use RuleTestTrait;

    public function provideCheckData(): array
    {
        return [['AppIconsExistPassed', true], ['AppIconsExistFailed', false]];
    }

    /** @dataProvider provideCheckData */
    public function testCheck(string $blobFileName, bool $expectedResult): void
    {
        $this->assertSame($expectedResult, $this->rule->check(...$this->createArgumentsFromBlob($blobFileName)));
    }

    protected function getRuleClass(): string
    {
        return AppIconsExist::class;
    }
}
