<?php

namespace Tests;

use App\Services\UrlHelper;
use GuzzleHttp\Client;
use Mockery;
use Mockery\MockInterface;

class UrlHelperTest extends TestCase
{
    /** @var MockInterface&Client */
    private $client;

    /** @var UrlHelper */
    private $helper;

    public function setUp(): void
    {
        parent::setUp();

        $this->client = Mockery::mock(Client::class);
        $this->helper = new UrlHelper($this->client);
    }

    public function provideRootUrlTestData(): array
    {
        return [
            ['http://foo.bar', 'http://foo.bar/'],
            ['http://localhost:8000/index.php', 'http://localhost:8000/'],
            ['http://foo.bar/baz/qux.html?foo=bar#home', 'http://foo.bar/'],
        ];
    }

    /** @dataProvider provideRootUrlTestData */
    public function testGetRootUrl(string $fullUrl, string $rootUrl): void
    {
        $this->assertEquals($rootUrl, $this->helper->getRootUrl($fullUrl));
    }

    public function testGetRootFileUrl(): void
    {
        $this->assertEquals(
            'http://foo.bar/.htaccess',
            (string) $this->helper->getRootFileUrl('http://foo.bar/baz/qux.html', '/.htaccess')
        );
    }

    public function testDefaultFaviconUrl(): void
    {
        $this->assertEquals(
            'http://foo.bar/favicon.ico',
            (string) $this->helper->getDefaultFaviconUrl('http://foo.bar/baz/qux.html')
        );
    }

    public function testGetRobotsUrl(): void
    {
        $this->assertEquals(
            'http://foo.bar/robots.txt',
            (string) $this->helper->getRobotsTxtUrl('http://foo.bar/baz/qux.html')
        );
    }

    public function testDefaultSiteMapUrl()
    {
        $this->assertEquals(
            'http://foo.bar/sitemap.xml',
            (string) $this->helper->getDefaultSiteMapUrl('http://foo.bar/baz/qux.html')
        );
    }

    public function provideAbsolutizeTestData(): array
    {
        return [
            ['dir/sitemap.xml', 'http://foo.bar/baz/qux.html', 'http://foo.bar/baz/dir/sitemap.xml'],
            ['/sitemap.xml', 'http://foo.bar/baz/qux.html', 'http://foo.bar/sitemap.xml'],
            ['http://baz.qux/sitemap.xml', 'http://foo.bar/baz/qux.html', 'http://baz.qux/sitemap.xml'],
        ];
    }

    /** @dataProvider provideAbsolutizeTestData */
    public function testAbsolutize(string $url, string $baseUrl, string $expected): void
    {
        $this->assertEquals($expected, (string) $this->helper->absolutize($url, $baseUrl));
    }
}
