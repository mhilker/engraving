<?php

declare(strict_types=1);

namespace Engraving\Test\Unit\Router\FastRoute;

use Engraving\Router\FastRoute\FastRouteRouter;
use Engraving\Router\RouteMatch\RouteMatchInterface;
use FastRoute\Dispatcher;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;

class FastRouteRouterTest extends TestCase
{
    /**
     * @var FastRouteRouter
     */
    private $router;

    /**
     * @var Dispatcher | \PHPUnit_Framework_MockObject_MockObject
     */
    private $dispatcher;

    public function setUp(): void
    {
        $this->dispatcher = $this->createMock(Dispatcher::class);

        $this->router = new FastRouteRouter($this->dispatcher);
    }

    /**
     * @covers \Engraving\Router\FastRoute\FastRouteRouter::__construct
     * @covers \Engraving\Router\FastRoute\FastRouteRouter::match
     */
    public function testCanMatchRequest(): void
    {
        $uri = $this->createMock(UriInterface::class);
        $uri->expects($this->once())->method('getPath')->willReturn('/uri/request/path');

        $request = $this->createMock(ServerRequestInterface::class);
        $request->expects($this->once())->method('getMethod')->willReturn('GET');
        $request->expects($this->once())->method('getUri')->willReturn($uri);

        $routeMatch = $this->router->match($request);

        $this->assertInstanceOf(RouteMatchInterface::class, $routeMatch);
    }
}
