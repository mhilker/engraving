<?php
declare(strict_types=1);

namespace Engraving\Middleware\Middleware\Factory;

use Engraving\Middleware\Middleware\RoutingMiddleware;
use Engraving\Router\RouterInterface;
use Psr\Container\ContainerInterface;

class RoutingMiddlewareFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return RoutingMiddleware
     */
    public function __invoke(ContainerInterface $container): RoutingMiddleware
    {
        $router = $container->get(RouterInterface::class);

        return new RoutingMiddleware($router);
    }
}
