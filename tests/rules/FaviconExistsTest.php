<?php

use App\Facades\UrlHelper;
use App\Rules\FaviconExists;
use Mockery as m;

class FaviconExistsTest extends TestCase
{
    public function testCheckDefaultFavicon()
    {
        UrlHelper::shouldReceive('getDefaultFaviconUrl', 'absolutize', [
            'exists' => true,
        ]);
        $crawler = $this->createCrawlerFromBlob('FaviconExists_DefaultFavicon');
        $rule = new FaviconExists($crawler);
        static::assertTrue($rule->check());
    }

    /*
     * Test <link rel="icon">
     */
    public function testCheckExplicitFaviconByLinkRelIcon()
    {
        UrlHelper::shouldReceive('absolutize', [
            'exists' => true,
        ]);
        UrlHelper::shouldReceive('getDefaultFaviconUrl')
            ->never();
        $crawler = $this->createCrawlerFromBlob('FaviconExists_RelIcon');
        $rule = new FaviconExists($crawler);
        static::assertTrue($rule->check());
    }

    /**
     * Test <link rel="shortcut icon">
     */
    public function testCheckExplicitFaviconByLinkRelShortcutIcon()
    {
        UrlHelper::shouldReceive('absolutize', [
            'exists' => true,
        ]);
        UrlHelper::shouldReceive('getDefaultFaviconUrl')
            ->never();
        $crawler = $this->createCrawlerFromBlob('FaviconExists_RelShortcutIcon');
        $rule = new FaviconExists($crawler);
        static::assertTrue($rule->check());
    }
}
