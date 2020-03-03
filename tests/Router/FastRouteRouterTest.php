<?php

declare(strict_types=1);

namespace Engraving\Router;

use Engraving\Router\RouteMatch\RouteMatchInterface;
use FastRoute\Dispatcher;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

/**
 * @covers \Engraving\Router\FastRouteRouter
 */
final class FastRouteRouterTest extends TestCase
{
    public function testCanMatchRequest(): void
    {
        $dispatcher = $this->createMock(Dispatcher::class);

        $uri = $this->createMock(UriInterface::class);
        $uri->expects($this->once())->method('getPath')->willReturn('/uri/request/path');

        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->once())->method('getMethod')->willReturn('GET');
        $request->expects($this->once())->method('getUri')->willReturn($uri);

        $router = new FastRouteRouter($dispatcher);
        $routeMatch = $router->match($request);

        $this->assertInstanceOf(RouteMatchInterface::class, $routeMatch);
    }
}
