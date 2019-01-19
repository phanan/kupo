<?php

namespace Tests\Rules;

use App\Rules\GoogleAnalyticsInstalled;
use Tests\TestCase;

class GoogleAnalyticsInstalledTest extends TestCase
{
    use RuleTestTrait;

    public function provideCheckData(): array
    {
        return [
            ['GoogleAnalyticsInstalledPassed', true, 'UA-12345678-9'],
            ['GoogleAnalyticsInstalledPassed_Unicode', true, 'UA\u002D2997484\u002D1'],
            ['GoogleAnalyticsInstalledFailed', false, null],
        ];
    }

    /** @dataProvider provideCheckData */
    public function testCheck(string $blobFileName, bool $expectedResult, ?string $expectedGaCode): void
    {
        $this->assertSame($expectedResult, $this->rule->check(...$this->createArgumentsFromBlob($blobFileName)));
        $this->assertSame($expectedGaCode, $this->rule->getGaCode());
    }

    protected function getRuleClass(): string
    {
        return GoogleAnalyticsInstalled::class;
    }
}
