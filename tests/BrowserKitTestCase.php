<?php

namespace Tests;

use App\Crawler;
use Illuminate\Contracts\Console\Kernel;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;

abstract class BrowserKitTestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Create a Crawler instance from a blob file's content.
     *
     * @param $name string Name of the blob file.
     *
     * @return Crawler
     */
    public function createCrawlerFromBlob($name)
    {
        if (!ends_with($name, '.html')) {
            $name = "$name.html";
        }

        return new Crawler(file_get_contents(__DIR__."/blobs/$name"));
    }
}
