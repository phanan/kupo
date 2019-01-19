<?php

namespace Tests\Rules;

use App\Rules\TwitterOGTagsExist;
use Tests\TestCase;

class TwitterOGTagsExistTest extends TestCase
{
    use RuleTestTrait;

    public function provideCheckData(): array
    {
        return [['TwitterOGTagsExistPassed', true], ['TwitterOGTagsExistFailed', false]];
    }

    /** @dataProvider provideCheckData */
    public function testCheck(string $blobFileName, bool $expectedResult): void
    {
        $this->assertSame($expectedResult, $this->rule->check(...$this->createArgumentsFromBlob($blobFileName)));
    }

    protected function getRuleClass(): string
    {
        return TwitterOGTagsExist::class;
    }
}
