<?php

namespace App;

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
     * @return string
     *
     * @throws \Exception
     */
    public function getRaw()
    {
        if ($this->rawHtml) {
            return $this->rawHtml;
        }

        throw new \Exception("Can't get raw HTML. Make sure you have initialized Crawler with a string.");
    }
}
