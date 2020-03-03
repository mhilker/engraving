<?php

declare(strict_types=1);

namespace Engraving\Router\RouteMatch;

use Engraving\Router\Exception\BadMethodCallException;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Engraving\Router\RouteMatch\RouteMatch
 */
final class RouteMatchTest extends TestCase
{
    public function testCanCreateSuccessfulRouteMatch(): void
    {
        $routeMatch = RouteMatch::fromSuccess('test', ['foo' => 'bar']);

        $this->assertTrue($routeMatch->isSuccess());
        $this->assertFalse($routeMatch->isFailure());
        $this->assertFalse($routeMatch->isMethodFailure());

        $this->assertEquals('test', $routeMatch->getAction());
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

    public function testThrowsExceptionToAccessActionFromFailedRouteMatch(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Unable to get action from failed route match.');

        $routeMatch = RouteMatch::fromFailure();
        $routeMatch->getAction();
    }

    public function testThrowsExceptionToAccessParametersFromFailedRouteMatch(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Unable to get parameters from failed route match.');

        $routeMatch = RouteMatch::fromFailure();
        $routeMatch->getParameters();
    }

    public function testThrowsExceptionToAccessAllowedMethodsFromNonMethodFailureRouteMatch(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Unable to get allowed methods from route match without method failure.');

        $routeMatch = RouteMatch::fromFailure();
        $routeMatch->getAllowedMethods();
    }
}
