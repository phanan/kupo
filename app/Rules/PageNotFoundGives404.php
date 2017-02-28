<?php

namespace App\Rules;

use App\Services\UrlFetcher;
use GuzzleHttp\Exception\BadResponseException;

class PageNotFoundGives404 extends Rule
{
    protected $statusCode;

    /**
     * {@inheritdoc}
     */
    public function check()
    {
        $uri = rtrim($this->url, '/').'/-~!page-to-test-404-responses-for-invalid-pages!~-';

        $fetcher = new UrlFetcher();
        try {
            $response = $fetcher->fetch($uri)->getResponse();
        } catch (BadResponseException $e) {
            $response = $e->getResponse();
        }

        $this->statusCode = $response ? $response->getStatusCode() : '-';

        return $this->statusCode === 404;
    }

    /**
     * {@inheritdoc}
     */
    public function level()
    {
        return Levels::CRITICAL;
    }

    /**
     * {@inheritdoc}
     */
    public function passedMessage()
    {
        return 'Not found page correctly return a `404` status.';
    }

    /**
     * {@inheritdoc}
     */
    public function failedMessage()
    {
        return 'Not found page returned `'.$this->statusCode.'` instead of `404`.';
    }

    /**
     * {@inheritdoc}
     */
    public function helpMessage()
    {
        return <<<'MSG'
Make sure every page returns the correct status code. Pages not returning 404 will be indexed by search engines.
MSG;
    }
}
