<?php

namespace App\Services;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\UriInterface;

class UrlHelper
{
    /**
     * Get the root URL (with ending slash) from a base one.
     * For instance, providing 'http://google.com/index.html?q=l' will return 'http://google.com/'.
     *
     * @param $url
     *
     * @return UriInterface
     */
    public function getRootUrl($url)
    {
        return (new Uri($url))->withPath('/')->withQuery('')->withFragment('');
    }

    /**
     * Get the URL of a file at the root of an URL.
     * For instance, providing 'http://google.com/index.html' and 'sitemap.xml' will return
     * 'http://google.com/sitemap.xml'.
     *
     * @param $url      string
     * @param $fileName string
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function getRootFileUrl($url, $fileName)
    {
        return $this->getRootUrl($url)->withPath($fileName);
    }

    /**
     * Get the default favicon URL from a base URL.
     * For instance, providing 'http://google.com/index.html' will return
     * 'http://google.com/favicon.ico'.
     *
     * @param $url string
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function getDefaultFaviconUrl($url)
    {
        return $this->getRootFileUrl($url, '/favicon.ico');
    }

    /**
     * Get the default robots.txt URL from a base URL.
     * For instance, providing 'http://google.com/index.html' will return
     * 'http://google.com/robots.txt'.
     *
     * @param $url string
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function getRobotsUrl($url)
    {
        return $this->getRootFileUrl($url, '/robots.txt');
    }

    /**
     * Get the default site map URL from a base URL.
     * For instance, providing 'http://google.com/index.html' will return
     * 'http://google.com/sitemap.xml'.
     *
     * @param $url string
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function getDefaultSiteMapUrl($url)
    {
        return $this->getRootFileUrl($url, '/sitemap.xml');
    }

    /**
     * Get the www or non-www counterparts of an URL.
     * For example, providing 'http://google.com' will return 'http://www.google.com'.
     * and vice-versa.
     *
     * @param $url string
     *
     * @return string
     */
    public function getWwwOrNonWwwCounterpart($url)
    {
        $parts = parse_url($url);
        if (starts_with(strtolower($parts['host']), 'www.')) {
            return preg_replace('/www\./i', '', $url, 1);
        } else {
            $parts['host'] = "www.{$parts['host']}";

            return http_build_url($parts);
        }
    }

    /**
     * Checks if an URL/file exists.
     *
     * @param             $url
     * @param Client|null $client
     *
     * @return bool
     */
    public function exists($url, Client $client = null)
    {
        $client = $client ?: new Client();

        try {
            $client->request('HEAD', $url);

            return true;
        } catch (ClientException $e) {
            if ($e->getCode() !== 403) {
                return false;
            }

            // Some servers forbid HEAD requests (for example Quora's).
            // In such cases, try a full GET.
            try {
                $client->request('GET', $url);

                return true;
            } catch (ClientException $e) {
                return false;
            }
        }
    }

    /**
     * Make a URL absolute.
     *
     * @param string $url     The URL
     * @param string $baseUrl The base URL
     *
     * @return string
     */
    public function absolutize($url, $baseUrl)
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
