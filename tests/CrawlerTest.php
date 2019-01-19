<?php

namespace Tests;

use App\Crawler;
use Exception;

class CrawlerTest extends TestCase
{
    /** @var Crawler */
    private $crawler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->crawler = new Crawler();
    }

    public function provideAttributeXPathData(): array
    {
        return [
            [
                'meta[http-equiv="content-type"]',
                'descendant-or-self::meta[translate(@http-equiv, "ABCDEFGHJIKLMNOPQRSTUVWXYZ", "abcdefghjiklmnopqrstuvwxyz") = \'content-type\']',
            ],
            [
                'link[rel=icon]',
                'descendant-or-self::link[translate(@rel, "ABCDEFGHJIKLMNOPQRSTUVWXYZ", "abcdefghjiklmnopqrstuvwxyz") = \'icon\']',
            ],
            [
                'link[rel=icon], link[rel="shortcut icon"]',
                'descendant-or-self::link[translate(@rel, "ABCDEFGHJIKLMNOPQRSTUVWXYZ", "abcdefghjiklmnopqrstuvwxyz") = \'icon\'] | descendant-or-self::link[translate(@rel, "ABCDEFGHJIKLMNOPQRSTUVWXYZ", "abcdefghjiklmnopqrstuvwxyz") = \'shortcut icon\']',
            ],
        ];
    }

    /**
     * @dataProvider provideAttributeXPathData
     * @throws Exception
     */
    public function testCreateCaseInsensitiveAttributeXPath(string $selector, string $expected): void
    {
        $this->assertEquals($expected, $this->crawler->createCaseInsensitiveAttributeXPath($selector));
    }
}
