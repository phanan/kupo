<?php

namespace Tests\Rules;

use App\Rules\DocTypeCorrect;
use Tests\TestCase;

class DocTypeCorrectTest extends TestCase
{
    use RuleTestTrait;

    public function provideCheckData(): array
    {
        return [
            ['DocTypeCorrectPassed', true, '<!DOCTYPE html>'],
            ['DocTypeCorrectFailed', false, null],
        ];
    }

    /** @dataProvider provideCheckData */
    public function testCheck(string $blobFileName, bool $expectedResult, ?string $expectedDocType): void
    {
        $this->assertSame($expectedResult, $this->rule->check(...$this->createArgumentsFromBlob($blobFileName)));
        $this->assertSame($expectedDocType, $this->rule->getDocType());
    }

    protected function getRuleClass(): string
    {
        return DocTypeCorrect::class;
    }
}
