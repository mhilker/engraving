<?php

declare(strict_types=1);

namespace Engraving;

use Engraving\Emitter\ResponseEmitter;
use Engraving\Pipeline\Pipeline;
use Engraving\Router\Router;
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
        $pipeline = $this->createMock(Pipeline::class);
        $emitter = $this->createMock(ResponseEmitter::class);
        $router = $this->createMock(Router::class);

        $pipeline->expects($this->once())
            ->method('pipe')
            ->with($serverRequest)
            ->willReturn($response);

        $application = new Application($pipeline, $router, $emitter);
        $application->run($serverRequest);
    }
}
