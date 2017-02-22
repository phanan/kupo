<?php

namespace Tests\Rules;

use App\Rules\AppIconsExist;
use Tests\BrowserKitTestCase;

class AppIconsExistTest extends BrowserKitTestCase
{
    public function testCheck()
    {
        $crawler = $this->createCrawlerFromBlob('AppIconsExistPassed');
        $rule = new AppIconsExist($crawler);
        static::assertTrue($rule->check());

        $crawler = $this->createCrawlerFromBlob('AppIconsExistFailed');
        $rule = new AppIconsExist($crawler);
        static::assertFalse($rule->check());
    }
}
