<?php

namespace Tests\Rules;

use App\Rules\GoogleAnalyticsInstalled;
use Tests\BrowserKitTestCase;

class GoogleAnalyticsInstalledTest extends BrowserKitTestCase
{
    public function testCheck()
    {
        $args = $this->createArgumentsFromBlob('GoogleAnalyticsInstalledPassed');
        $rule = new GoogleAnalyticsInstalled();
        static::assertTrue($rule->check(...$args));
        static::assertEquals('UA-12345678-9', $rule->getGaCode());

        $args = $this->createArgumentsFromBlob('GoogleAnalyticsInstalledFailed');
        $rule = new GoogleAnalyticsInstalled();
        static::assertFalse($rule->check(...$args));
    }
}
