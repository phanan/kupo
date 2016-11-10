<?php

use App\Facades\Markdown;

if (!function_exists('md')) {
    function md($text) {
        return Markdown::parse($text);
    }
}
