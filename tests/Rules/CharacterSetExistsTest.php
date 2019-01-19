<?php

namespace Tests\Rules;

use App\Rules\CharacterSetExists;
use Tests\TestCase;

class CharacterSetExistsTest extends TestCase
{
    use RuleTestTrait;

    public function provideCheckData(): array
    {
        return [
            ['CharacterSetExistsPassed_HTML5', true, 'UTF-8'],
            ['CharacterSetExistsPassed_HTML4', true, 'ISO-8859-1'],
            ['CharacterSetExistsFailed', false, null],
        ];
    }

    /** @dataProvider provideCheckData */
    public function testCheck(string $blobFileName, bool $expectedResult, ?string $expectedCharset): void
    {
        $this->assertSame($expectedResult, $this->rule->check(...$this->createArgumentsFromBlob($blobFileName)));
        $this->assertSame($expectedCharset, $this->rule->getCharset());
    }

    protected function getRuleClass(): string
    {
        return CharacterSetExists::class;
    }
}
