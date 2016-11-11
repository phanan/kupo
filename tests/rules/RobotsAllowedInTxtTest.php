<?php

use App\Facades\RobotsFile;
use App\Rules\RobotsAllowedInTxt;

class RobotsAllowedInTxtTest extends TestCase
{
    public function testCheck()
    {
        RobotsFile::setContent('');
        $rule = new RobotsAllowedInTxt();
        static::assertTrue($rule->check());

        RobotsFile::setContent('
 User-Agent: *
 Disallow: /
');
        $rule = new RobotsAllowedInTxt();
        static::assertFalse($rule->check());
    }
}
