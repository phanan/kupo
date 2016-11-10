<?php

namespace App\Rules;

class ImgTagsHaveAlt extends Rule
{

    /**
     * @inheritdoc
     */
    public function check()
    {
        foreach ($this->crawler->filter('img') as $img) {
            if (!trim($img->getAttribute('alt'))) {
                return false;
            }
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function level()
    {
        return Levels::NOTICE;
    }

    /**
     * @inheritdoc
     */
    public function passedMessage()
    {
        return 'All `<img>` tags have proper `alt` values';
    }

    /**
     * @inheritdoc
     */
    public function failedMessage()
    {
        return 'At least one `<img>` tag doesn\'t have a proper `alt` value';
    }
}
