<?php

namespace Tests\Rules;

use App\Rules\RobotsAllowedInTxt;
use App\Services\Markdown;
use App\Services\RobotsTxtFile;
use App\Services\UrlHelper;
use GuzzleHttp\Client;
use Mockery;
use Mockery\MockInterface;
use Tests\TestCase;

class RobotsAllowedInTxtTest extends TestCase
{
    use RuleTestTrait {
        setUp as private baseSetUp;
    }

    /** @var MockInterface&RobotsTxtFile */
    private $robotTxtFile;

    protected function setUp(): void
    {
        $this->markdown = Mockery::mock(Markdown::class);
        $this->client = Mockery::mock(Client::class);
        $this->urlHelper = Mockery::mock(UrlHelper::class);
        $this->robotTxtFile = Mockery::mock(RobotsTxtFile::class);

        $this->rule = new RobotsAllowedInTxt($this->markdown, $this->client, $this->urlHelper, $this->robotTxtFile);
    }

    public function testCheckPassed(): void
    {
        $this->urlHelper
            ->shouldReceive('getRobotsTxtUrl')
            ->with('http://foo.bar/PlainResponse.txt')
            ->andReturn('http://foo.bar/robots.txt');

        $this->robotTxtFile
            ->shouldReceive('setUrl')
            ->with('http://foo.bar/robots.txt');

        $this->robotTxtFile
            ->shouldReceive('getContent')
            ->andReturn('');

        $this->robotTxtFile
            ->shouldReceive('isPathAllowed')
            ->never();

        $this->assertTrue($this->rule->check(...$this->createArgumentsFromMessage('PlainResponse')));
    }

    public function testCheckFailed(): void
    {
        $this->urlHelper
            ->shouldReceive('getRobotsTxtUrl')
            ->with('http://foo.bar/PlainResponse.txt')
            ->andReturn('http://foo.bar/robots.txt');

        $this->robotTxtFile
            ->shouldReceive('setUrl')
            ->with('http://foo.bar/robots.txt');

        $this->robotTxtFile
            ->shouldReceive('getContent')
            ->andReturn('User-Agent: *' . PHP_EOL . 'Disallow: /');

        $this->robotTxtFile
            ->shouldReceive('isPathAllowed')
            ->with('/')
            ->andReturn(false);

        $this->assertFalse($this->rule->check(...$this->createArgumentsFromMessage('PlainResponse')));
    }

    protected function getRuleClass(): string
    {
        return RobotsAllowedInTxt::class;
    }
}
