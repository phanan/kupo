<?php

namespace App\Rules;

use App\Crawler;
use DOMElement;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class ImgTagsHaveAlt extends Rule
{
    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri): bool
    {
        return collect($crawler->filter('img'))->every(static function (DOMElement $node): bool {
            return (bool) trim($node->getAttribute('alt'));
        });
    }

    public function level(): string
    {
        return Levels::NOTICE;
    }

    public function passedMessage(): string
    {
        return 'All `<img>` tags have proper `alt` values.';
    }

    public function failedMessage(): string
    {
        return 'At least one `<img>` tag doesn’t have a proper `alt` value.';
    }

    public function helpMessage(): string
    {
        return <<<'MSG'
An `alt` attribute specifies the alternate text for an image, which comes in handy if the image cannot be displayed for some reason, or if the user uses a screen reader, kupo! 
MSG;
    }
}
