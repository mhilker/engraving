<?php

declare(strict_types=1);

namespace Engraving;

use Engraving\Emitter\ResponseEmitter;
use Engraving\Pipeline\Pipeline;
use Engraving\Router\Router;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class Application
{
    private Pipeline $pipeline;
    private Router $router;
    private ResponseEmitter $emitter;

    public function __construct(Pipeline $pipeline, Router $router, ResponseEmitter $emitter)
    {
        $this->pipeline = $pipeline;
        $this->router = $router;
        $this->emitter = $emitter;
    }

    public function addRoute(string $method, string $pattern, RequestHandlerInterface $handler): void
    {
        $this->router->addRoute($method, $pattern, $handler);
    }

    public function addMiddleware(MiddlewareInterface $middleware): void
    {
        $this->pipeline->addMiddleware($middleware);
    }

    public function run(ServerRequestInterface $request): void
    {
        $response = $this->pipeline->pipe($request);

        $this->emitter->emit($response);
    }
}
