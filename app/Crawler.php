<?php

namespace App;

use Symfony\Component\CssSelector\CssSelectorConverter;
use Symfony\Component\DomCrawler\Crawler as BaseCrawler;

class Crawler extends BaseCrawler
{
    protected $rawHtml;

    /**
     * @param mixed  $node       A Node to use as the base for the crawling
     * @param string $currentUri The current URI
     * @param string $baseHref   The base href value
     */
    public function __construct($node = null, $currentUri = null, $baseHref = null)
    {
        if (is_string($node)) {
            $this->rawHtml = $node;
        }

        parent::__construct($node, $currentUri, $baseHref);
    }

    /**
     * Get the original raw HTML.
     *
     * @throws \Exception
     *
     * @return string
     */
    public function getRaw()
    {
        if ($this->rawHtml) {
            return $this->rawHtml;
        }

        throw new \Exception("Can't get raw HTML. Make sure you have initialized Crawler with a string.");
    }

    /**
     * Filter by a CSS attribute selector case-insensitively.
     * This method is very limited in term of capability (only works for 'attr[key=val]', with val
     * being Latin-only).
     *
     * @param $selector string The selector string
     *
     * @throws \Exception
     *
     * @return BaseCrawler
     */
    public function filterCaseInsensitiveAttribute($selector)
    {
        $selector = strtolower($selector);
        
        return $this->filterXPath($this->createCaseInsensitiveAttributeXPath($selector));
    }

    /**
     * Convert a CSS attribute selector into XPath case-insensitively.
     *
     * @param $selector
     *
     * @throws \Exception
     *
     * @return string
     */
    public function createCaseInsensitiveAttributeXPath($selector)
    {
        $converter = new CssSelectorConverter(true);
        $xpath = $converter->toXPath($selector);

        $re = '/(@(.*?))\s*=/';
        if (!preg_match_all($re, $xpath, $matches)) {
            throw new \Exception("$selector is not a valid/usable CSS selector.");
        }

        return preg_replace($re, 'translate($1, "ABCDEFGHJIKLMNOPQRSTUVWXYZ", "abcdefghjiklmnopqrstuvwxyz") =', $xpath);
    }
}
