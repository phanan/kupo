<?php

namespace Tests\Rules;

use App\Rules\NoBrokenLinksOnPage;
use App\Services\Markdown;
use App\Services\UrlHelper;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Mockery;
use Tests\TestCase;

class NoBrokenLinksOnPageTest extends TestCase
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
        return [[[200, 200], true], [[302, 200], true], [[200, 404, 404], false]];
    }

    /**
     * @dataProvider provideCheckData
     *
     * @param int[] $statusCodes
     */
    public function testCheck(array $statusCodes, bool $expectedResult): void
    {
        $mock = new MockHandler(
            collect($statusCodes)->map(static function (int $code): Response {
                return new Response($code);
            })->all()
        );

        $client = new Client(['handler' => HandlerStack::create($mock)]);

        $rule = new NoBrokenLinksOnPage($this->markdown, $client, $this->urlHelper);
        $this->assertSame($expectedResult, $rule->check(...$this->createArgumentsFromBlob('NoBrokenLinksOnPage')));
    }

    protected function getRuleClass(): string
    {
        return NoBrokenLinksOnPage::class;
    }
}
