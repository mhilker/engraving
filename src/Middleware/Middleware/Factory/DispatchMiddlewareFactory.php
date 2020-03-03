<?php
declare(strict_types=1);

namespace Engraving\Middleware\Middleware\Factory;

use Engraving\Middleware\Middleware\DispatchMiddleware;
use Psr\Container\ContainerInterface;

class DispatchMiddlewareFactory
{
    /**
     * @param ContainerInterface $container
     * @return DispatchMiddleware
     */
    public function __invoke(ContainerInterface $container): DispatchMiddleware
    {
        return new DispatchMiddleware($container);
    }
}
