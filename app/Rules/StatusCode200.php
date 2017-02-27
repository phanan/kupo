<?php

namespace App\Rules;

use App\Facades\UrlFetcher;

class StatusCode200 extends Rule
{
    protected $statusCode;

    /**
     * {@inheritdoc}
     */
    public function check()
    {
        return UrlFetcher::getResponse()->getStatusCode() == 200;
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
        return 'Page correctly returned a `200` status.';
    }

    /**
     * {@inheritdoc}
     */
    public function failedMessage()
    {
        return 'This page returned '.$this->statusCode.' instead of `200`.';
    }

    /**
     * {@inheritdoc}
     */
    public function helpMessage()
    {
        return <<<'MSG'
Make sure every page returns the correct status code. Pages with incorrect status codes will not be correctly indexed by search engines.
MSG;
    }
}
