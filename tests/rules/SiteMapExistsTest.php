<?php

namespace Tests\Rules;

use App\Crawler;
use App\Facades\RobotsFile;
use App\Facades\UrlHelper;
use App\Rules\SiteMapExists;
use GuzzleHttp\Psr7\Uri;
use Mockery as m;
use Tests\BrowserKitTestCase;

class SiteMapExistsTest extends BrowserKitTestCase
{
    public function testCheckDefaultSitemaps()
    {
        $parser = m::mock(RobotsTxtParser::class, [
            'getSitemaps' => [],
        ]);

        $rule = new SiteMapExists();
        RobotsFile::shouldReceive('getParser')
            ->once()
            ->andReturn($parser);
        UrlHelper::shouldReceive('getDefaultSiteMapUrl')
            ->once()
            ->with('http://foo.bar/PlainResponse.txt')
            ->andReturn('http://foo.bar/sitemap.xml');
        UrlHelper::shouldReceive('absolutize')
            ->once();
        UrlHelper::shouldReceive('exists')
            ->once()
            ->andReturn(true);

        $args = $this->createArgumentsFromMessage('PlainResponse');
        static::assertTrue($rule->check(...$args));
    }

    public function testCheckSitemapsInRobotsTxtFile()
    {
        $parser = m::mock(RobotsTxtParser::class, [
            'getSitemaps' => [
                'http://foo.bar/map.xml',
                'http://quo.foo.bar/map.xml',
            ],
        ]);

        $rule = new SiteMapExists();
        RobotsFile::shouldReceive('getParser')
            ->once()
            ->andReturn($parser);
        UrlHelper::shouldReceive('absolutize')
            ->twice();
        UrlHelper::shouldReceive('exists')
            ->twice()
            ->andReturn(false);

        $args = $this->createArgumentsFromMessage('PlainResponse');
        static::assertFalse($rule->check(...$args));
    }
}
