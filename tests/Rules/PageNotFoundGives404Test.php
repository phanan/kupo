<?php

namespace Tests\Rules;

use App\Rules\PageNotFoundGives404;
use App\Services\Markdown;
use App\Services\UrlHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Mockery;
use Tests\TestCase;

class PageNotFoundGives404Test extends TestCase
{
    use RuleTestTrait {
        setUp as private baseSetup;
    }

    protected function setUp(): void
    {
        $this->markdown = Mockery::mock(Markdown::class);
        $this->urlHelper = Mockery::mock(UrlHelper::class);
    }

    public function provideCheckData(): array
    {
        return [[404, true], [500, false]];
    }

    /** @dataProvider provideCheckData */
    public function testCheckPassed(int $statusCode, bool $expectedResult): void
    {
        $this->urlHelper
            ->shouldReceive('getRootFileUrl')
            ->once()
            ->with('http://foo.bar/PlainResponse.txt', PageNotFoundGives404::NOT_FOUND_PATH);

        $handler = HandlerStack::create(new MockHandler([new Response($statusCode)]));
        $client = new Client(['handler' => $handler]);

        $rule = new PageNotFoundGives404($this->markdown, $client, $this->urlHelper);
        $this->assertSame($expectedResult, $rule->check(...$this->createArgumentsFromMessage('PlainResponse')));
    }

    protected function getRuleClass(): string
    {
        return PageNotFoundGives404::class;
    }
}
