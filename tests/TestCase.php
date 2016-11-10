<?php

use App\Crawler;

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

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
