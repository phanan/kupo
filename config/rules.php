<?php

return [
    App\Rules\TitleExists::class,
    App\Rules\MetaDescriptionExists::class,
    App\Rules\AppIconsExist::class,
    App\Rules\CharacterSetExists::class,
    App\Rules\DocTypeCorrect::class,
    App\Rules\FaviconExists::class,
    App\Rules\GoogleAnalyticsInstalled::class,
    App\Rules\GzipEnabled::class,
    App\Rules\SiteMapExists::class,
    App\Rules\RobotsAllowedInTxt::class,
    App\Rules\RobotsAllowedInMetaTag::class,
    App\Rules\FacebookOGTagsExist::class,
    App\Rules\TwitterOGTagsExist::class,
];
