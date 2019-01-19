<?php

namespace Tests\Rules;

use App\Rules\FaviconExists;
use Tests\TestCase;

class FaviconExistsTest extends TestCase
{
    use RuleTestTrait;

    public function testCheckDefaultFavicon(): void
    {
        $this->urlHelper->shouldReceive('getDefaultFaviconUrl', 'absolutize', ['exists' => true]);

        $this->assertTrue($this->rule->check(...$this->createArgumentsFromBlob('FaviconExists_DefaultFavicon')));
    }

    /*
     * Test <link rel="icon">
     */
    public function testCheckExplicitFaviconByLinkRelIcon(): void
    {
        $this->urlHelper->shouldReceive('absolutize', ['exists' => true]);

        $this->urlHelper
            ->shouldReceive('getDefaultFaviconUrl')
            ->never();

        $this->assertTrue($this->rule->check(...$this->createArgumentsFromBlob('FaviconExists_RelIcon')));
    }

    /**
     * Test <link rel="shortcut icon">.
     */
    public function testCheckExplicitFaviconByLinkRelShortcutIcon()
    {
        $this->urlHelper
            ->shouldReceive('exists')
            ->withArgs(['http://foo.bar/icon.png'])
            ->andReturn(true);

        $this->urlHelper
            ->shouldReceive('getDefaultFaviconUrl')
            ->never();

        $this->assertTrue($this->rule->check(...$this->createArgumentsFromBlob('FaviconExists_RelShortcutIcon')));
    }

    /**
     * Test <link rel="shortcut icon">.
     */
    public function testCheckExplicitRelativeFaviconByLinkRelShortcutIcon()
    {
        $this->urlHelper
            ->shouldReceive('exists')
            ->withArgs(['http://foo.bar/icon.png'])
            ->andReturn(true);

        $this->urlHelper
            ->shouldReceive('getDefaultFaviconUrl')
            ->never();

        $this->assertTrue($this->rule->check(...$this->createArgumentsFromBlob('FaviconExists_RelShortcutIconRelative')));
    }

    protected function getRuleClass(): string
    {
        return FaviconExists::class;
    }
}
