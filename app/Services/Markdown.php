<?php

namespace App\Services;

use Parsedown;

class Markdown
{
    /**
     * @var Parsedown
     */
    private $parsedown;

    public function __construct(Parsedown $parsedown = null)
    {
        $this->parsedown = $parsedown ?: new Parsedown();
    }

    /**
     * Parse markdown into HTML.
     *
     * @param $text string The markdown text.
     *
     * @return string
     */
    public function parse($text)
    {
        return $this->parsedown->parse($text);
    }
}
