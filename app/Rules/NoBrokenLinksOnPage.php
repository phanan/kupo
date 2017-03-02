<?php

namespace App\Rules;

use App\Crawler;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class NoBrokenLinksOnPage extends Rule
{
    protected $statusCode;

    protected $msg = null;

    /** @var Client */
    protected $client;

    /**
     * Check for broken links on the page.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function check(Crawler $crawler, ResponseInterface $response, UriInterface $uri)
    {
        $requests = [];

        foreach ($crawler->filter('a')->links() as $link) {
            $uri = $link->getUri();

            // Get HEAD to check if exists
            $request = new Request('HEAD', $uri);

            // Strip fragment
            $uri = $request->getUri()->withFragment('');
            $request = $request->withUri($uri);

            if (in_array($uri->getScheme(), ['http', 'https'])) {
                $requests[(string) $request->getUri()] = $request;
            }
        }

        if (empty($requests)) {
            $this->msg = 'No links found..';

            return true;
        }

        $ok = 0;
        $fail = [];
        $pool = new Pool($this->client, $requests, [
            'concurrency' => 5,
            'fulfilled' => function (ResponseInterface $response) use (&$ok) {
                $ok++;
            },
            'rejected' => function (RequestException $eHead) use (&$ok, &$fail) {
                // Retry the request as HEAD, as not every host supports HEAD
                $retryRequest = $eHead->getRequest()->withMethod('GET');

                try {
                    $this->client->send($retryRequest);
                    $ok++;
                } catch (RequestException $eRetry) {
                    if ($response = $eRetry->getResponse()) {
                        $result = "* `{$response->getStatusCode()} {$response->getReasonPhrase()}` - ";
                    } else {
                        $result = '* `XXX UNKNOWN` - ';
                    }

                    $result .= $eRetry->getRequest()->getUri();
                    $fail[] = $result;
                }
            },
        ]);

        // Initiate the transfers and create a promise
        $promise = $pool->promise();

        // Force the pool of requests to complete.
        $promise->wait();

        if (empty($fail)) {
            $this->msg = "All **{$ok}** links on this page are working!";

            return true;
        }

        $this->msg = "Not all links on this page are working. {$ok} links are working, but **".count($fail)." failed**:\n\n".implode("\n", $fail);

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function level()
    {
        return Levels::CRITICAL;
    }

    /**
     * {@inheritdoc}
     */
    public function passedMessage()
    {
        return $this->msg;
    }

    /**
     * {@inheritdoc}
     */
    public function failedMessage()
    {
        return $this->msg;
    }

    /**
     * {@inheritdoc}
     */
    public function helpMessage()
    {
        return <<<'MSG'
Make sure all links on your page are working.
MSG;
    }
}
