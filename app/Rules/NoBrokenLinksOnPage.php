<?php

namespace App\Rules;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

class NoBrokenLinksOnPage extends Rule
{
    protected $statusCode;

    protected $msg = null;

    /**
     * {@inheritdoc}
     */
    public function check()
    {
        $requests = [];

        foreach ($this->crawler->filter('a')->links() as $link) {
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
        $client = new Client();
        $pool = new Pool($client, $requests, [
            'concurrency' => 5,
            'fulfilled' => function (ResponseInterface $response) use (&$ok) {
                $ok++;
            },
            'rejected' => function (RequestException $eHead) use ($client, &$ok, &$fail) {
                $retryRequest = $eHead->getRequest()->withMethod('GET');

                try {
                    $client->send($retryRequest);
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
