<?php

declare(strict_types=1);

namespace Engraving\Router;

use Engraving\Router\Exception\RouterException;
use PHPUnit\Framework\TestCase;
use Psr\Http\Server\RequestHandlerInterface;

/**
 * @covers \Engraving\Router\RouteMatch
 */
final class RouteMatchTest extends TestCase
{
    public function testCanCreateSuccessfulRouteMatch(): void
    {
        $handler = $this->createMock(RequestHandlerInterface::class);

        $routeMatch = RouteMatch::fromSuccess($handler, ['foo' => 'bar']);

        $this->assertTrue($routeMatch->isSuccess());
        $this->assertFalse($routeMatch->isFailure());
        $this->assertFalse($routeMatch->isMethodFailure());

        $this->assertEquals($handler, $routeMatch->getHandler());
        $this->assertEquals(['foo' => 'bar'], $routeMatch->getParameters());
    }

    public function testCanCreateRouteMatchFromFailure(): void
    {
        $routeMatch = RouteMatch::fromFailure();

        $this->assertFalse($routeMatch->isSuccess());
        $this->assertTrue($routeMatch->isFailure());
        $this->assertFalse($routeMatch->isMethodFailure());
    }

    public function testCanCreateRouteMatchWithMethodFailure(): void
    {
        $routeMatch = RouteMatch::fromFailure(['GET', 'POST']);

        $this->assertFalse($routeMatch->isSuccess());
        $this->assertTrue($routeMatch->isFailure());
        $this->assertTrue($routeMatch->isMethodFailure());
        $this->assertEquals(['GET', 'POST'], $routeMatch->getAllowedMethods());
    }

    public function testThrowsExceptionToAccessHandlerFromFailedRouteMatch(): void
    {
        $this->expectException(RouterException::class);
        $this->expectExceptionMessage('Unable to get request handler from failed route match.');

        $routeMatch = RouteMatch::fromFailure();
        $routeMatch->getHandler();
    }

    public function testThrowsExceptionToAccessParametersFromFailedRouteMatch(): void
    {
        $this->expectException(RouterException::class);
        $this->expectExceptionMessage('Unable to get parameters from failed route match.');

        $routeMatch = RouteMatch::fromFailure();
        $routeMatch->getParameters();
    }

    public function testThrowsExceptionToAccessAllowedMethodsFromNonMethodFailureRouteMatch(): void
    {
        $this->expectException(RouterException::class);
        $this->expectExceptionMessage('Unable to get allowed methods from route match without method failure.');

        $routeMatch = RouteMatch::fromFailure();
        $routeMatch->getAllowedMethods();
    }
}
