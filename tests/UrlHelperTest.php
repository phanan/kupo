<?php

namespace Tests;

use App\Services\UrlHelper;

class UrlHelperTest extends BrowserKitTestCase
{
    /**
     * @var UrlHelper
     */
    private $helper;

    public function setUp()
    {
        $this->helper = new UrlHelper();
        parent::setUp();
    }

    public function testGetRootUrl()
    {
        static::assertEquals(
            'http://foo.bar/',
            (string) $this->helper->getRootUrl('http://foo.bar')
        );
        static::assertEquals(
            'http://localhost:8000/',
            (string) $this->helper->getRootUrl('http://localhost:8000/index.php')
        );
        static::assertEquals(
            'http://foo.bar/',
            (string) $this->helper->getRootUrl('http://foo.bar/baz/qux.html?foo=bar#home')
        );
    }

    public function testGetRootFileUrl()
    {
        static::assertEquals(
            'http://foo.bar/.htaccess',
            (string) $this->helper->getRootFileUrl('http://foo.bar/baz/qux.html', '/.htaccess')
        );
    }

    public function testDefaultFaviconUrl()
    {
        static::assertEquals(
            'http://foo.bar/favicon.ico',
            (string) $this->helper->getDefaultFaviconUrl('http://foo.bar/baz/qux.html')
        );
    }

    public function testGetRobotsUrl()
    {
        static::assertEquals(
            'http://foo.bar/robots.txt',
            (string) $this->helper->getRobotsUrl('http://foo.bar/baz/qux.html')
        );
    }

    public function testDefaultSiteMapUrl()
    {
        static::assertEquals(
            'http://foo.bar/sitemap.xml',
            (string) $this->helper->getDefaultSiteMapUrl('http://foo.bar/baz/qux.html')
        );
    }

    public function testAbsolutize()
    {
        static::assertEquals(
            'http://foo.bar/baz/dir/sitemap.xml',
            (string) $this->helper->absolutize('dir/sitemap.xml', 'http://foo.bar/baz/qux.html')
        );

        static::assertEquals(
            'http://foo.bar/sitemap.xml',
            (string) $this->helper->absolutize('/sitemap.xml', 'http://foo.bar/baz/qux.html')
        );

        static::assertEquals(
            'http://baz.qux/sitemap.xml',
            (string) $this->helper->absolutize('http://baz.qux/sitemap.xml', 'http://foo.bar/baz/qux.html')
        );
    }
}
