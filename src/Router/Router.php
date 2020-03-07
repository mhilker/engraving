<?php

declare(strict_types=1);

namespace Engraving\Router;

use Engraving\Router\Exception\RouterException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

interface Router
{
    /**
     * @throws RouterException
     */
    public function match(ServerRequestInterface $serverRequest): RouteMatch;

    public function addRoute(string $method, string $pattern, RequestHandlerInterface $handler): void;
}
