<?php

namespace App\Services;

use Parsedown;

class Markdown
{
    private $parser;

    public function __construct(Parsedown $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Parse markdown into HTML.
     *
     * @param $text string The markdown text
     *
     * @return string
     */
    public function parse($text): string
    {
        return $this->parser->parse($text);
    }
}
