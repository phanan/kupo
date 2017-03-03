<?php

$rules = [
    App\Rules\RobotsAllowedInTxt::class,
    App\Rules\RobotsAllowedInMetaTag::class,
    App\Rules\TitleExists::class,
    App\Rules\MetaDescriptionExists::class,
    App\Rules\CharacterSetExists::class,
    App\Rules\DocTypeCorrect::class,
    App\Rules\HtmlHasLangAttribute::class,
    App\Rules\FaviconExists::class,
    App\Rules\AppIconsExist::class,
    App\Rules\SiteMapExists::class,
    App\Rules\ImgTagsHaveAlt::class,
    App\Rules\GoogleAnalyticsInstalled::class,
    App\Rules\GzipEnabled::class,
    App\Rules\FacebookOGTagsExist::class,
    App\Rules\TwitterOGTagsExist::class,
    App\Rules\PageNotFoundGives404::class,
    App\Rules\NoBrokenLinksOnPage::class,
];

if ($custom = config('customRules')) {
    $rules = array_merge($rules, $custom);
}

return $rules;
