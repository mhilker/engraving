<?php

declare(strict_types=1);

namespace Engraving\Middleware\Pipeline;

use Engraving\Middleware\Pipeline\Exception\InvalidMiddlewareException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class QueuePipeline implements PipelineInterface, RequestHandlerInterface
{
    private iterable $queue;

    public function __construct(iterable $queue)
    {
        self::assertMiddlewareInterface($queue);
        $this->queue = $queue;
    }

    private static function assertMiddlewareInterface(iterable $queue)
    {
        foreach ($queue as $item) {
            if ($item instanceof MiddlewareInterface) {
                continue;
            }

            throw InvalidMiddlewareException::invalidType($item);
        }
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
