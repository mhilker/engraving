<?php

declare(strict_types=1);

namespace Engraving\Action;

use Engraving\Template\RendererInterface;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * @covers \Engraving\Action\IndexAction
 */
final class IndexActionTest extends TestCase
{
    public function testCanReturnResponse(): void
    {
        $request = $this->createMock(ServerRequestInterface::class);
        $renderer = $this->createMock(RendererInterface::class);

        $action = new IndexAction($renderer);
        $response = $action->handle($request);

        $this->assertInstanceOf(ResponseInterface::class, $response);
    }
}
