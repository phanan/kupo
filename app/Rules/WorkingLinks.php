<?php

namespace App\Rules;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;

class WorkingLinks extends Rule
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
            $request = new Request('GET', $uri, [
                'User-Agent'      => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/27.0.1453.110 Safari/537.36',
                'Accept-Encoding' => 'gzip',
            ]);

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
            'fulfilled' => function (ResponseInterface $response) use(&$ok) {
                $ok++;
            },
            'rejected' => function (RequestException $e) use(&$fail) {

                if ($response = $e->getResponse()) {
                    $result = "`{$response->getStatusCode()} {$response->getReasonPhrase()}` - ";
                } else {
                    $result = "`XXX UNKNOWN` - ";
                }

                $result .= $e->getRequest()->getUri();
                $fail[] = $result;
            },
        ]);

        // Initiate the transfers and create a promise
        $promise = $pool->promise();

        // Force the pool of requests to complete.
        $promise->wait();

        if (empty($fail)) {
            $this->msg = "All {$ok} links work!";
            return true;
        }

        $this->msg = "`{$ok}` links are working, `". count($fail) ."` failed:<br/>" . implode("<br/>", $fail);

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
Make sure all links are working.
MSG;
    }
}
