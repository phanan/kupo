<?php

namespace App\Rules;

use App\Crawler;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class AppIconsExist extends Rule
{
    /** @throws Exception */
    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri): bool
    {
        // To keep things simple, we only check for the tags' existence,
        // not the icon files themselves.
        return count($crawler->filterCaseInsensitiveAttribute('link[rel=apple-touch-icon]'))
            || count($crawler->filterCaseInsensitiveAttribute('link[rel=icon]'));
    }

    public function level(): string
    {
        return Levels::NOTICE;
    }

    public function passedMessage(): string
    {
        return 'App icons for mobile devices found.';
    }

    public function failedMessage(): string
    {
        return 'App icons for mobile devices not found.';
    }

    public function helpMessage(): string
    {
        return <<<'MSG'
App icons are used when your web page is saved to the home screen of a mobile device. They are specified by `<link rel="apple-touch-icon">` for iOS and `<link rel="icon">` for Android. Note that you can specify more than one icon to cater for different resolutions. 
You can read more about app icons for [iOS](https://developer.apple.com/library/content/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html) and [Android](https://developer.chrome.com/multidevice/android/installtohomescreen), kupo!
MSG;
    }
}
