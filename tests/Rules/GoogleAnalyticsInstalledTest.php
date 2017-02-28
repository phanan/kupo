<?php

namespace Tests\Rules;

use App\Rules\GoogleAnalyticsInstalled;
use Tests\BrowserKitTestCase;

class GoogleAnalyticsInstalledTest extends BrowserKitTestCase
{
    public function testCheck()
    {
        $crawler = $this->createCrawlerFromBlob('GoogleAnalyticsInstalledPassed');
        $rule = new GoogleAnalyticsInstalled($crawler);
        static::assertTrue($rule->check());
        static::assertEquals('UA-12345678-9', $rule->getGaCode());

        $crawler = $this->createCrawlerFromBlob('GoogleAnalyticsInstalledFailed');
        $rule = new GoogleAnalyticsInstalled($crawler);
        static::assertFalse($rule->check());
    }
}
