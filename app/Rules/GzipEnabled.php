<?php

namespace App\Rules;

use App\Crawler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class GzipEnabled extends Rule
{
    /**
     * {@inheritdoc}
     */
    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri)
    {
        // When the content is decoded by Guzzle, the X-Encoded header is used
        $encoding = $response->getHeader('Content-Encoding') + $response->getHeader('X-Encoded-Content-Encoding');

        // We check if the header contains the gzip content-encoding.
        return in_array('gzip', $encoding, true);
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
        return <<<'MSG'
Compressing your web page helps reduce loading time and save bandwidth. If your server is Apache, this can be done with [some simple `.htaccess` rules](https://github.com/phanan/htaccess#compress-text-files), kupo! 
MSG;
    }
}
