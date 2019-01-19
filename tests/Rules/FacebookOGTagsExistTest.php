<?php

namespace Tests\Rules;

use App\Rules\FacebookOGTagsExist;
use Tests\TestCase;

class FacebookOGTagsExistTest extends TestCase
{
    use RuleTestTrait;

    public function provideCheckData(): array
    {
        return [['FacebookOGTagsExistPassed', true], ['FacebookOGTagsExistFailed', false]];
    }

    /** @dataProvider provideCheckData */
    public function testCheck(string $blobFileName, bool $expectedResult): void
    {
        $this->assertSame($expectedResult, $this->rule->check(...$this->createArgumentsFromBlob($blobFileName)));
    }

    protected function getRuleClass(): string
    {
        return FacebookOGTagsExist::class;
    }
}
