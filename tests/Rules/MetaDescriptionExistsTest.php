<?php

namespace Tests\Rules;

use App\Rules\MetaDescriptionExists;
use Tests\TestCase;

class MetaDescriptionExistsTest extends TestCase
{
    use RuleTestTrait;

    public function provideCheckData(): array
    {
        return [
            ['MetaDescriptionExistsPassed', true, 'A foo walks into a bar.'],
            ['MetaDescriptionExistsFailed', false, null],
        ];
    }

    /** @dataProvider provideCheckData */
    public function testCheck(string $blobFileName, bool $expectedResult, ?string $expectedDescription): void
    {
        $this->assertSame($expectedResult, $this->rule->check(...$this->createArgumentsFromBlob($blobFileName)));
        $this->assertSame($expectedDescription, $this->rule->getDescription());
    }

    protected function getRuleClass(): string
    {
        return MetaDescriptionExists::class;
    }
}
