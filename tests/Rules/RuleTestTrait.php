<?php

namespace Tests\Rules;

use App\Crawler;
use App\Rules\RuleInterface;
use App\Services\Markdown;
use App\Services\UrlHelper;
use GuzzleHttp\Client;
use function GuzzleHttp\Psr7\parse_response;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use Mockery;
use Mockery\MockInterface;

trait RuleTestTrait
{
    /** @var RuleInterface */
    private $rule;

    /** @var MockInterface&Markdown */
    private $markdown;

    /** @var MockInterface&Client */
    private $client;

    /** @var MockInterface&UrlHelper */
    private $urlHelper;

    protected function setUp(): void
    {
        $this->markdown = Mockery::mock(Markdown::class);
        $this->client = Mockery::mock(Client::class);
        $this->urlHelper = Mockery::mock(UrlHelper::class);

        $className = $this->getRuleClass();
        $this->rule = new $className($this->markdown, $this->client, $this->urlHelper);
    }

    /**
     * Create a Crawler instance from a blob file's content.
     *
     * @param $name string Name of the blob file.
     */
    public function createArgumentsFromBlob(string $name): array
    {
        if (!ends_with($name, '.html')) {
            $name = "$name.html";
        }

        $response = new Response(200, [], file_get_contents(__DIR__."/../blobs/$name"));
        $uri = new Uri('http://foo.bar/'.$name);
        $crawler = new Crawler($response, $uri);

        return [$crawler, $response, $uri];
    }

    /**
     * Create a Crawler instance from a message file's content.
     *
     * @param $name string Name of the message file.
     */
    public function createArgumentsFromMessage(string $name): array
    {
        if (!ends_with($name, '.txt')) {
            $name = "$name.txt";
        }

        $response = parse_response(file_get_contents(__DIR__."/../messages/$name"));

        $uri = new Uri('http://foo.bar/'.$name);
        $crawler = new Crawler($response, $uri);

        return [$crawler, $response, $uri];
    }

    abstract protected function getRuleClass(): string;
}
