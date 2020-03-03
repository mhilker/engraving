<?php

declare(strict_types=1);

namespace Engraving\Test\Unit\Router;

use Engraving\Router\Exception\BadMethodCallException;
use Engraving\Router\RouteMatch\RouteMatch;
use PHPUnit\Framework\TestCase;

class RouteMatchTest extends TestCase
{
    /**
     * @covers \Engraving\Router\RouteMatch\RouteMatch::__construct
     * @covers \Engraving\Router\RouteMatch\RouteMatch::fromSuccess
     * @covers \Engraving\Router\RouteMatch\RouteMatch::getAction
     * @covers \Engraving\Router\RouteMatch\RouteMatch::getParameters
     * @covers \Engraving\Router\RouteMatch\RouteMatch::getAllowedMethods
     */
    public function testCanCreateSuccessfullRouteMatch(): void
    {
        $routeMatch = RouteMatch::fromSuccess('test', ['foo' => 'bar']);

        $this->assertTrue($routeMatch->isSuccess());
        $this->assertFalse($routeMatch->isFailure());
        $this->assertFalse($routeMatch->isMethodFailure());

        $this->assertEquals('test', $routeMatch->getAction());
        $this->assertEquals(['foo' => 'bar'], $routeMatch->getParameters());
    }

    /**
     * @covers \Engraving\Router\RouteMatch\RouteMatch::__construct
     * @covers \Engraving\Router\RouteMatch\RouteMatch::fromFailure
     * @covers \Engraving\Router\RouteMatch\RouteMatch::isFailure
     * @covers \Engraving\Router\RouteMatch\RouteMatch::isSuccess
     * @covers \Engraving\Router\RouteMatch\RouteMatch::isMethodFailure
     */
    public function testCanCreateRouteMatchFromFailure(): void
    {
        $routeMatch = RouteMatch::fromFailure();

        $this->assertFalse($routeMatch->isSuccess());
        $this->assertTrue($routeMatch->isFailure());
        $this->assertFalse($routeMatch->isMethodFailure());
    }

    /**
     * @covers \Engraving\Router\RouteMatch\RouteMatch::__construct
     * @covers \Engraving\Router\RouteMatch\RouteMatch::fromFailure
     * @covers \Engraving\Router\RouteMatch\RouteMatch::getAllowedMethods
     * @covers \Engraving\Router\RouteMatch\RouteMatch::isFailure
     * @covers \Engraving\Router\RouteMatch\RouteMatch::isSuccess
     * @covers \Engraving\Router\RouteMatch\RouteMatch::isMethodFailure
     */
    public function testCanCreateRouteMatchWithMethodFailure(): void
    {
        $routeMatch = RouteMatch::fromFailure(['GET', 'POST']);

        $this->assertFalse($routeMatch->isSuccess());
        $this->assertTrue($routeMatch->isFailure());
        $this->assertTrue($routeMatch->isMethodFailure());
        $this->assertEquals(['GET', 'POST'], $routeMatch->getAllowedMethods());
    }

    /**
     * @uses \Engraving\Router\RouteMatch\RouteMatch::__construct
     * @uses \Engraving\Router\RouteMatch\RouteMatch::fromFailure
     * @uses \Engraving\Router\RouteMatch\RouteMatch::isMethodFailure
     * @covers \Engraving\Router\RouteMatch\RouteMatch::getAction
     */
    public function testThrowsExceptionToAccessActionFromFailedRouteMatch(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Unable to get action from failed route match.');

        $routeMatch = RouteMatch::fromFailure();
        $routeMatch->getAction();
    }

    /**
     * @uses \Engraving\Router\RouteMatch\RouteMatch::__construct
     * @uses \Engraving\Router\RouteMatch\RouteMatch::fromFailure
     * @uses \Engraving\Router\RouteMatch\RouteMatch::isMethodFailure
     * @covers \Engraving\Router\RouteMatch\RouteMatch::getParameters
     */
    public function testThrowsExceptionToAccessParametersFromFailedRouteMatch(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Unable to get parameters from failed route match.');

        $routeMatch = RouteMatch::fromFailure();
        $routeMatch->getParameters();
    }

    /**
     * @uses \Engraving\Router\RouteMatch\RouteMatch::__construct
     * @uses \Engraving\Router\RouteMatch\RouteMatch::fromFailure
     * @uses \Engraving\Router\RouteMatch\RouteMatch::isMethodFailure
     * @covers \Engraving\Router\RouteMatch\RouteMatch::getAllowedMethods
     */
    public function testThrowsExceptionToAccessAllowedMethodsFromNonMethodFailureRouteMatch(): void
    {
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage('Unable to get allowed methods from route match without method failure.');

        $routeMatch = RouteMatch::fromFailure();
        $routeMatch->getAllowedMethods();
    }
}
