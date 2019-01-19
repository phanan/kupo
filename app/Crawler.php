<?php

namespace App;

use Exception;
use Psr\Http\Message\ResponseInterface;
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
        if ($node instanceof ResponseInterface) {
            $node = (string) $node->getBody();
        }

        parent::__construct($node, $currentUri, $baseHref);
    }

    /**
     * Filter by a CSS attribute selector case-insensitively.
     * This method is very limited in term of capability (only works for 'attr[key=val]', with val
     * being Latin-only).
     *
     * @param $selector string The selector string
     *
     * @throws Exception
     *
     * @return BaseCrawler
     */
    public function filterCaseInsensitiveAttribute(string $selector): BaseCrawler
    {
        $selector = strtolower($selector);

        return $this->filterXPath($this->createCaseInsensitiveAttributeXPath($selector));
    }

    /**
     * Convert a CSS attribute selector into XPath case-insensitively.
     *
     * @param string $selector
     *
     * @return string
     * @throws Exception
     */
    public function createCaseInsensitiveAttributeXPath(string $selector): string
    {
        $converter = new CssSelectorConverter(true);
        $xpath = $converter->toXPath($selector);

        $re = '/(@(.*?))\s*=/';

        if (!preg_match_all($re, $xpath, $matches)) {
            throw new Exception("$selector is not a valid/usable CSS selector.");
        }

        return preg_replace($re, 'translate($1, "ABCDEFGHJIKLMNOPQRSTUVWXYZ", "abcdefghjiklmnopqrstuvwxyz") =', $xpath);
    }
}
