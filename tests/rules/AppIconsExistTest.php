<?php

use App\Rules\AppIconsExist;

class AppIconsExistTest extends TestCase
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
