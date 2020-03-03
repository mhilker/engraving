<?php

declare(strict_types=1);

namespace Engraving\Router\FastRoute\Factory;

use Engraving\Router\FastRoute\Exception\ConfigurationException;
use Engraving\Router\FastRoute\FastRouteRouter;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Psr\Container\ContainerInterface;
use function FastRoute\cachedDispatcher;

class FastRouteRouterFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return FastRouteRouter
     */
    public function __invoke(ContainerInterface $container): FastRouteRouter
    {
        $config = $config = $container->get('config');
        $dispatcher = $this->createDispatcher($config);

        return new FastRouteRouter($dispatcher);
    }

    /**
     * @param iterable $config
     *
     * @return Dispatcher
     */
    private function createDispatcher(iterable $config): Dispatcher
    {
        $options = $config['router']['fastroute'] ?? [];
        $routes = $config['router']['routes'] ?? [];

        if (is_iterable($options) === false) {
            throw ConfigurationException::invalidOptions($options);
        }

        if (is_iterable($routes) === false) {
            throw ConfigurationException::invalidRoutes($routes);
        }

        $callback = function (RouteCollector $routeCollector) use ($routes) {
            foreach ($routes as $route) {
                // TODO: Check if the keys exists
                $routeCollector->addRoute($route['method'], $route['route'], $route['handler']);
            }
        };

        return cachedDispatcher($callback, $options);
    }
}
