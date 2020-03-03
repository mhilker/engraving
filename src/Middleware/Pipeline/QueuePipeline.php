<?php

declare(strict_types=1);

namespace Engraving\Middleware\Pipeline;

use Engraving\Middleware\Pipeline\Exception\InvalidMiddlewareException;
use Engraving\Middleware\Pipeline\Exception\PipelineException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class QueuePipeline implements PipelineInterface, RequestHandlerInterface
{
    /**
     * @var MiddlewareInterface[]|iterable
     */
    private $queue = [];

    /**
     * @param MiddlewareInterface[]|iterable $queue
     * @throws PipelineException
     */
    public function __construct(iterable $queue)
    {
        self::assertMiddlewareInterface($queue);
        $this->queue = $queue;
    }

    /**
     * @param iterable $queue
     * @throws PipelineException
     */
    private static function assertMiddlewareInterface(iterable $queue)
    {
        foreach ($queue as $item) {
            if ($item instanceof MiddlewareInterface) {
                continue;
            }

            throw InvalidMiddlewareException::invalidType($item);
        }
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function pipe(ServerRequestInterface $request): ResponseInterface
    {
        $current = array_shift($this->queue);
        return $current->process($request, $this);
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->pipe($request);
    }
}
