<?php

namespace Tests\Rules;

use App\Rules\SiteMapExists;
use App\Services\Markdown;
use App\Services\RobotsTxtFile;
use App\Services\UrlHelper;
use GuzzleHttp\Client;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class SiteMapExistsTest extends TestCase
{
    use RuleTestTrait {
        setUp as private baseSetUp;
    }

    /** @var RobotsTxtFile&MockInterface */
    private $robotTxtFile;

    protected function setUp(): void
    {
        $this->markdown = Mockery::mock(Markdown::class);
        $this->client = Mockery::mock(Client::class);
        $this->urlHelper = Mockery::mock(UrlHelper::class);
        $this->robotTxtFile = Mockery::mock(RobotsTxtFile::class);

        $this->rule = new SiteMapExists($this->markdown, $this->client, $this->urlHelper, $this->robotTxtFile);
    }

    public function testCheckDefaultSitemaps(): void
    {
        $this->urlHelper
            ->shouldReceive('getDefaultSiteMapUrl')
            ->once()
            ->with('http://foo.bar/PlainResponse.txt')
            ->andReturn('http://foo.bar/sitemap.xml');

        $this->robotTxtFile
            ->shouldReceive('setUrl')
            ->with('http://foo.bar/robots.txt');

        $this->robotTxtFile
            ->shouldReceive('getSitemaps')
            ->andReturn([]);

        $this->urlHelper
            ->shouldReceive('getRobotsTxtUrl')
            ->with('http://foo.bar/PlainResponse.txt')
            ->andReturn('http://foo.bar/robots.txt');

        $this->urlHelper
            ->shouldReceive('absolutize')
            ->once()
            ->with('http://foo.bar/sitemap.xml', 'http://foo.bar/PlainResponse.txt')
            ->andReturn('http://foo.bar/sitemap.xml');

        $this->urlHelper
            ->shouldReceive('exists')
            ->once()
            ->with('http://foo.bar/sitemap.xml')
            ->andReturn(true);

        $this->assertTrue($this->rule->check(...$this->createArgumentsFromMessage('PlainResponse')));
    }

    public function testCheckSitemapsInRobotsTxtFile(): void
    {
        $this->urlHelper
            ->shouldReceive('getDefaultSiteMapUrl')
            ->never();

        $this->urlHelper
            ->shouldReceive('getRobotsTxtUrl')
            ->with('http://foo.bar/PlainResponse.txt')
            ->andReturn('http://foo.bar/robots.txt');

        $this->robotTxtFile
            ->shouldReceive('setUrl')
            ->with('http://foo.bar/robots.txt');

        $this->robotTxtFile
            ->shouldReceive('getSitemaps')
            ->andReturn(['http://foo.bar/map.xml', 'http://quo.foo.bar/map.xml']);

        $this->urlHelper
            ->shouldReceive('absolutize')
            ->twice();

        $this->urlHelper
            ->shouldReceive('exists')
            ->twice()
            ->andReturn(false);

        $this->assertFalse($this->rule->check(...$this->createArgumentsFromMessage('PlainResponse')));
    }

    protected function getRuleClass(): string
    {
        return SiteMapExists::class;
    }
}
