<?php

namespace App\Rules;

use App\Crawler;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Request as IlluminateRequest;
use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class NoBrokenLinksOnPage extends Rule
{
    private $resultMessage;

    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri): bool
    {
        $requests = [];
        $ok = 0;
        $fail = [];

        foreach ($crawler->filter('a')->links() as $link) {
            $uri = $link->getUri();

            try {
                // Get HEAD to check if exists
                $request = new Request(IlluminateRequest::METHOD_HEAD, $uri);
            } catch (InvalidArgumentException $e) {
                // Unable to parse URI exception
                $fail[] = '* `Bad URL format` - '.$uri;
                continue;
            }

            // Strip fragment
            $uri = $request->getUri()->withFragment('');
            $request = $request->withUri($uri);

            if (in_array($uri->getScheme(), ['http', 'https'], true)) {
                $requests[(string) $request->getUri()] = $request;
            }
        }

        if (empty($requests)) {
            $this->resultMessage = 'No links found.';

            return true;
        }

        $pool = new Pool($this->client, $requests, [
            'concurrency' => 5,
            'fulfilled' => static function () use (&$ok): void {
                $ok++;
            },
            'rejected' => function (RequestException $e) use (&$ok, &$fail): void {
                if ($e->getCode() !== 403) {
                    // Retry the request as GET, as not every host supports HEAD
                    $retryRequest = $e->getRequest()->withMethod(IlluminateRequest::METHOD_GET);

                    try {
                        $this->client->send($retryRequest);
                        $ok++;

                        return;
                    } catch (RequestException $retryException) {
                        // Failed again
                    }
                }

                if ($response = $e->getResponse()) {
                    $result = "* `{$response->getStatusCode()} {$response->getReasonPhrase()}` - ";
                } else {
                    $result = '* `UNKNOWN ERROR` - ';
                }

                $result .= $e->getRequest()->getUri();
                $fail[] = $result;
            },
        ]);

        // Initiate the transfers and create a promise
        $promise = $pool->promise();

        // Force the pool of requests to complete.
        $promise->wait();

        $this->resultMessage = $fail
            ? 'Found **'.count($fail).'** broken '.str_plural('link', count($fail)).':'.PHP_EOL.PHP_EOL.implode(PHP_EOL, $fail)
            : "All $ok ".str_plural('link', $ok).' on the page are working.';

        return !$fail;
    }

    public function passedMessage(): string
    {
        return $this->resultMessage;
    }

    public function failedMessage(): string
    {
        return $this->resultMessage;
    }

    public function helpMessage(): string
    {
        return 'Make sure all links on your page are working, kupo!';
    }
}
