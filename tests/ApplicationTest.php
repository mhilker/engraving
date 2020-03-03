<?php

declare(strict_types=1);

namespace Engraving;

use Engraving\Emitter\EmitterInterface;
use Engraving\Middleware\Pipeline\PipelineInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @covers \Engraving\Application
 */
final class ApplicationTest extends TestCase
{
    public function testCanEmitResponse(): void
    {
        $serverRequest = $this->createMock(ServerRequestInterface::class);
        $response = $this->createMock(ResponseInterface::class);
        $pipeline = $this->createMock(PipelineInterface::class);
        $emitter = $this->createMock(EmitterInterface::class);

        $pipeline->expects($this->once())
            ->method('pipe')
            ->with($serverRequest)
            ->willReturn($response);

        $application = new Application($pipeline, $emitter);
        $application->run($serverRequest);
    }
}
