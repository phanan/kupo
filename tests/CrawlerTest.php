<?php

namespace Tests;

use App\Crawler;

class CrawlerTest extends TestCase
{
    public function testCreateCaseInsensitiveAttributeXPath()
    {
        $crawler = new Crawler();

        $compares = [
            'meta[http-equiv="content-type"]'           => 'descendant-or-self::meta[translate(@http-equiv, "ABCDEFGHJIKLMNOPQRSTUVWXYZ", "abcdefghjiklmnopqrstuvwxyz") = \'content-type\']',
            'link[rel=icon]'                            => 'descendant-or-self::link[translate(@rel, "ABCDEFGHJIKLMNOPQRSTUVWXYZ", "abcdefghjiklmnopqrstuvwxyz") = \'icon\']',
            'link[rel=icon], link[rel="shortcut icon"]' => 'descendant-or-self::link[translate(@rel, "ABCDEFGHJIKLMNOPQRSTUVWXYZ", "abcdefghjiklmnopqrstuvwxyz") = \'icon\'] | descendant-or-self::link[translate(@rel, "ABCDEFGHJIKLMNOPQRSTUVWXYZ", "abcdefghjiklmnopqrstuvwxyz") = \'shortcut icon\']',
        ];

        foreach ($compares as $selector => $expected) {
            static::assertEquals($expected, $crawler->createCaseInsensitiveAttributeXPath($selector));
        }
    }
}
