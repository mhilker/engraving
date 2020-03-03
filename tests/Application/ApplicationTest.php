<?php

declare(strict_types=1);

namespace Engraving\Application;

use Engraving\Emitter\EmitterInterface;
use Engraving\Middleware\Pipeline\PipelineInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class ApplicationTest extends TestCase
{
    /**
     * @var Application
     */
    private $application;

    /**
     * @var PipelineInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $pipeline;

    /**
     * @var EmitterInterface | \PHPUnit_Framework_MockObject_MockObject
     */
    private $emitter;

    public function setUp(): void
    {
        $this->pipeline = $this->createMock(PipelineInterface::class);
        $this->emitter = $this->createMock(EmitterInterface::class);

        $this->application = new Application($this->pipeline, $this->emitter);
    }

    /**
     * @covers \Engraving\Application\Application::__construct
     * @covers \Engraving\Application\Application::run
     */
    public function testCanEmitResponse(): void
    {
        $serverRequest = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);

        $this->pipeline->expects($this->once())
            ->method('pipe')
            ->with($serverRequest)
            ->willReturn($response);

        $this->application->run($serverRequest);
    }
}
