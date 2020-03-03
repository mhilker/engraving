<?php

declare(strict_types=1);

namespace Engraving\Middleware\Pipeline\Factory;

use Engraving\Middleware\Pipeline\Exception\PipelineEmptyException;
use Engraving\Middleware\Pipeline\Exception\PipelineException;
use Engraving\Middleware\Pipeline\QueuePipeline;
use Psr\Container\ContainerInterface;

class QueuePipelineFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @throws PipelineEmptyException
     * @throws PipelineException
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return QueuePipeline
     */
    public function __invoke(ContainerInterface $container): QueuePipeline
    {
        $config = $container->get('config');
        $config = $config['middleware']['pipeline'] ?? null;

        if ($config === null) {
            throw new PipelineEmptyException('Middleware pipeline must not be empty.');
        }

        $queue = [];
        foreach ($config as $item) {
            $queue[] = $container->get($item['name']);
        }

        return new QueuePipeline($queue);
    }
}
