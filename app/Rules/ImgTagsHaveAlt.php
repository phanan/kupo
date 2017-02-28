<?php

namespace App\Rules;

use App\Crawler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class ImgTagsHaveAlt extends Rule
{
    /**
     * {@inheritdoc}
     */
    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri)
    {
        foreach ($crawler->filter('img') as $img) {
            if (!trim($img->getAttribute('alt'))) {
                return false;
            }
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function level()
    {
        return Levels::NOTICE;
    }

    /**
     * {@inheritdoc}
     */
    public function passedMessage()
    {
        return 'All `<img>` tags have proper `alt` values.';
    }

    /**
     * {@inheritdoc}
     */
    public function failedMessage()
    {
        return 'At least one `<img>` tag doesn’t have a proper `alt` value.';
    }

    /**
     * {@inheritdoc}
     */
    public function helpMessage()
    {
        return <<<'MSG'
An `alt` attribute specifies the alternate text for an image, which comes in handy if the image cannot be displayed for some reason, or if the user uses a screen reader, kupo! 
MSG;
    }
}
