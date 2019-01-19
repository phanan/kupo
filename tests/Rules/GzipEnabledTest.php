<?php

namespace Tests\Rules;

use App\Rules\GzipEnabled;
use Tests\TestCase;

class GzipEnabledTest extends TestCase
{
    use RuleTestTrait;

    public function provideCheckData(): array
    {
        return [['GzippedResponse', true], ['PlainResponse', false]];
    }

    /** @dataProvider provideCheckData */
    public function testCheck(string $messageFileName, bool $expectedResult): void
    {
        $this->assertSame($expectedResult, $this->rule->check(...$this->createArgumentsFromMessage($messageFileName)));
    }

    protected function getRuleClass(): string
    {
        return GzipEnabled::class;
    }
}
