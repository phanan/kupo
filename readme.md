# kupo [![Build Status](https://travis-ci.org/phanan/kupo.svg?branch=master)](https://travis-ci.org/phanan/kupo)

> A simple site launch checklist checker (for the lack of a better name).

<img src="https://github.com/phanan/kupo/raw/master/screen.gif" width="488" height="auto" alt="Screen record">

## Why

After (or is it before?) lanching a new site, you often want to validate it against a checklist and make sure the title is filled, gzip is enabled, robots.txt and sitemap.xml are all there etc. **kupo** is built to help you with this tedious task. Just key in the site's address, hit <kbd>ENTER</kbd>, and it will check for:

* Title and description tags
* App icons' existence
* A character set
* A doc type
* A favicon
* A `lang` attribute
* Proper `alt` attributes on images
* `robots.txt` (and makes sure them bots are allowed)
* `sitemap.xml` for SEO purpose oh God I hate this
* Gzip to be enabled
* Google Analytics to be installed
* [Those OpenGraph tags that Facebook asks for](https://developers.facebook.com/docs/sharing/webmasters#markup)
* [Those funny markups that Twitter inquires](https://dev.twitter.com/cards/markup)
* Make sure every page returns the correct status code
* Make sure all links on your page are working
* …and more to come (or so I hope)

## Demo

Want to see Kupo in action?

[Kupo live demo](https://www.letsvalidate.com/)

## Install

As this tool is built on top of [Vue](https://vuejs.org) and [Laravel](https://laravel.com), your environment must meet their requirements. You'll also need a decent Node version (mine is `v6.9.1`) and [yarn](https://github.com/yarnpkg/yarn). Now from your command line, execute this bunch of commands:

```bash
git clone https://github.com/phanan/kupo.git
cd kupo
composer install
php artisan kupo:init
php artisan serve
// kupo should now have been started at http://localhost:8000/
```

## Extend

Depending on your needs, you may want to add more rules into kupo. In order to do so, just follow these certain steps:

1. Create a new Rule class: `php artisan make:rule FunnyBunnyMustBeSeen`
1. Open `app\Rules\FunnyBunnyMustBeSeen.php` and fill the class with your logic. Basically, you'll need to make sure `check()` returns a truthy/falsy value, indicating if the rule passes/fails. Other methods should be self-explanatory.
1. Now add `App\Rules\FunnyBunnyMustBeSeen::class` to the array found in `config/customRules.php`
1. That should be it!

## Contribute

If you feel like a certain rule should be added, please contribute! Just fork and follow the same steps as described in the above "Extend" section, except the file in step 3 should be `config/rules.php` instead. Create a passing test, make a PR, and I'll be more than happy to consider. Of course, bug fixes and any other kind of contributions are welcome, too!

## License

MIT © [Phan An](http://phanan.net)


