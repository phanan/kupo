<?php

namespace Tests\Rules;

use App\Facades\UrlHelper;
use App\Rules\FaviconExists;
use Tests\BrowserKitTestCase;

class FaviconExistsTest extends BrowserKitTestCase
{
    public function testCheckDefaultFavicon()
    {
        UrlHelper::shouldReceive('getDefaultFaviconUrl', 'absolutize', [
            'exists' => true,
        ]);

        $args = $this->createArgumentsFromBlob('FaviconExists_DefaultFavicon');
        $rule = new FaviconExists();
        static::assertTrue($rule->check(...$args));
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
        $args = $this->createArgumentsFromBlob('FaviconExists_RelIcon');
        $rule = new FaviconExists();
        static::assertTrue($rule->check(...$args));
    }

    /**
     * Test <link rel="shortcut icon">.
     */
    public function testCheckExplicitFaviconByLinkRelShortcutIcon()
    {
        UrlHelper::shouldReceive('exists')->withArgs(['http://foo.bar/icon.png'])->andReturn(true);
        UrlHelper::shouldReceive('getDefaultFaviconUrl')
            ->never();
        $args = $this->createArgumentsFromBlob('FaviconExists_RelShortcutIcon');
        $rule = new FaviconExists();
        static::assertTrue($rule->check(...$args));
    }

    /**
     * Test <link rel="shortcut icon">.
     */
    public function testCheckExplicitRelativeFaviconByLinkRelShortcutIcon()
    {
        UrlHelper::shouldReceive('exists')->withArgs(['http://foo.bar/icon.png'])->andReturn(true);
        UrlHelper::shouldReceive('getDefaultFaviconUrl')
            ->never();
        $args = $this->createArgumentsFromBlob('FaviconExists_RelShortcutIconRelative');
        $rule = new FaviconExists();
        static::assertTrue($rule->check(...$args));
    }
}
