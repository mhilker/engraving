<?php

declare(strict_types=1);

namespace Engraving\Pipeline;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class QueuePipeline implements Pipeline, RequestHandlerInterface
{
    private iterable $queue;

    public function __construct(iterable $queue = [])
    {
        foreach ($queue as $item) {
            $this->addMiddleware($item);
        }
    }

    public function addMiddleware(MiddlewareInterface $middleware): void
    {
        $this->queue[] = $middleware;
    }

    public function pipe(ServerRequestInterface $request): ResponseInterface
    {
        $current = array_shift($this->queue);
        return $current->process($request, $this);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->pipe($request);
    }
}
