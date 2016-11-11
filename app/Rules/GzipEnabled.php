<?php

namespace App\Rules;

use App\Facades\UrlFetcher;

class GzipEnabled extends Rule
{
    /**
     * {@inheritdoc}
     */
    public function check()
    {
        // We simply check the fetcher.
        return UrlFetcher::isGzipped();
    }

    /**
     * {@inheritdoc}
     */
    public function passedMessage()
    {
        return 'Content is gzipped.';
    }

    /**
     * {@inheritdoc}
     */
    public function failedMessage()
    {
        return 'Content is not gzipped.';
    }

    /**
     * {@inheritdoc}
     */
    public function helpMessage()
    {
        return <<<MSG
Compressing your web page helps reduce loading time and save bandwidth. If your server is Apache, this can be done with [some simple `.htaccess` rules](https://github.com/phanan/htaccess#compress-text-files), kupo! 
MSG;
    }
}
