<?php

namespace Tests\Rules;

use App\Rules\TitleExists;
use Tests\TestCase;

class TitleExistsTest extends TestCase
{
    use RuleTestTrait;

    public function provideCheckData(): array
    {
        return [['TitleExistsPassed', true, 'Foo'], ['TitleExistsFailed', false, null]];
    }

    /** @dataProvider provideCheckData */
    public function testCheck(string $blobFileName, bool $expectedResult, ?string $expectedTitle): void
    {
        $this->assertSame($expectedResult, $this->rule->check(...$this->createArgumentsFromBlob($blobFileName)));
        $this->assertSame($expectedTitle, $this->rule->getTitle());
    }

    protected function getRuleClass(): string
    {
        return TitleExists::class;
    }
}
