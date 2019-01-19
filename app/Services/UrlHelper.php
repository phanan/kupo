<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

class UrlHelper
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Get the root URL (with ending slash) from a base one.
     * For instance, providing 'http://google.com/index.html?q=l' will return 'http://google.com/'.
     */
    public function getRootUrl(string $url): UriInterface
    {
        return (new Uri($url))->withPath('/')->withQuery('')->withFragment('');
    }

    /**
     * Get the URL of a file at the root of an URL.
     * For instance, providing 'http://google.com/index.html' and 'sitemap.xml' will return
     * 'http://google.com/sitemap.xml'.
     */
    public function getRootFileUrl(string $url, string $fileName): string
    {
        return $this->getRootUrl($url)->withPath($fileName);
    }

    /**
     * Get the default favicon URL from a base URL.
     * For instance, providing 'http://google.com/index.html' will return 'http://google.com/favicon.ico'.
     */
    public function getDefaultFaviconUrl(string $url): string
    {
        return $this->getRootFileUrl($url, '/favicon.ico');
    }

    /**
     * Get the default robots.txt URL from a base URL.
     * For instance, providing 'http://google.com/index.html' will return 'http://google.com/robots.txt'.
     */
    public function getRobotsTxtUrl(string $url): string
    {
        return $this->getRootFileUrl($url, '/robots.txt');
    }

    /**
     * Get the default site map URL from a base URL.
     * For instance, providing 'http://google.com/index.html' will return 'http://google.com/sitemap.xml'.
     */
    public function getDefaultSiteMapUrl(string $url): string
    {
        return $this->getRootFileUrl($url, '/sitemap.xml');
    }

    /**
     * Get the www or non-www counterparts of an URL.
     * For example, providing 'http://google.com' will return 'http://www.google.com' and vice-versa.
     */
    public function getWwwOrNonWwwCounterpart(string $url): string
    {
        $parts = parse_url($url);

        if (starts_with(strtolower($parts['host']), 'www.')) {
            return preg_replace('/www\./i', '', $url, 1);
        }

        $parts['host'] = "www.{$parts['host']}";

        return http_build_url($parts);
    }

    /**
     * Checks if an URL/file exists.
     */
    public function exists(string $url): bool
    {
        try {
            $this->client->head($url);

            return true;
        } catch (ClientException $e) {
            if ($e->getCode() !== 403) {
                return false;
            }

            // Some servers forbid HEAD requests (for example Quora's).
            // In such cases, try a full GET.
            try {
                $this->client->get($url);

                return true;
            } catch (ClientException $e) {
                return false;
            }
        }
    }

    /**
     * Make a URL absolute.
     */
    public function absolutize(string $url, string $baseUrl): string
    {
        if (array_key_exists('scheme', parse_url($url))) {
            return $url; // the url is already absolute
        }

        if (starts_with($url, '//')) {
            // protocol-less url
            // We'll use the $checkedUrl's protocol.
            return parse_url($baseUrl)['scheme'].':'.$url;
        }

        if (starts_with($url, '/')) {
            // absolute URL
            return $this->getRootUrl($baseUrl).substr($url, 1);
        }

        // relative URL
        $pos = strrpos($baseUrl, '/');

        return substr_replace($baseUrl, $url, $pos + 1);
    }
}
