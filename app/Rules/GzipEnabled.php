<?php

namespace App\Rules;

use App\Facades\UrlFetcher;

class GzipEnabled extends Rule
{
    /**
     * @inheritdoc
     */
    public function check()
    {
        // We simply check the fetcher.
        return UrlFetcher::isGzipped();
    }

    /**
     * @inheritdoc
     */
    public function passedMessage()
    {
        return 'Content is gzipped';
    }

    /**
     * @inheritdoc
     */
    public function failedMessage()
    {
        return 'Content is not gzipped';
    }
}
