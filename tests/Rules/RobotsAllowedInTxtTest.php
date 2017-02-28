<?php

namespace Tests\Rules;

use App\Facades\RobotsFile;
use App\Rules\RobotsAllowedInTxt;
use Tests\BrowserKitTestCase;

class RobotsAllowedInTxtTest extends BrowserKitTestCase
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
