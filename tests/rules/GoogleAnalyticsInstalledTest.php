<?php

use App\Rules\GoogleAnalyticsInstalled;

class GoogleAnalyticsInstalledTest extends TestCase
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
