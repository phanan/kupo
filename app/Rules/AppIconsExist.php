<?php

namespace App\Rules;

class AppIconsExist extends Rule
{
    /**
     * {@inheritdoc}
     * @throws \RuntimeException
     */
    public function check()
    {
        // To keep things simple, we only check for the tags' existence,
        // not the icon files themselves.
        return
            count($this->crawler->filter('link[rel=apple-touch-icon]')) ||
            count($this->crawler->filter('link[rel=icon]'));
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
        return 'App icons for mobile devices found.';
    }

    /**
     * {@inheritdoc}
     */
    public function failedMessage()
    {
        return 'App icons for mobile devices not found.';
    }

    /**
     * {@inheritdoc}
     */
    public function helpMessage()
    {
        return <<<MSG
App icons are used when your web page is saved to the home screen of a mobile device. They are specified by `<link rel="apple-touch-icon">` for iOS and `<link rel="icon">` for Android. Note that you can specify more than one icon to cater for different resolutions. 
You can read more about app icons for [iOS](https://developer.apple.com/library/content/documentation/AppleApplications/Reference/SafariWebContent/ConfiguringWebApplications/ConfiguringWebApplications.html) and [Android](https://developer.chrome.com/multidevice/android/installtohomescreen), kupo!
MSG;
    }
}
