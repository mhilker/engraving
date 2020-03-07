<?php

declare(strict_types=1);

namespace Engraving\Router;

use Engraving\Router\Exception\RouterException;
use Exception;
use FastRoute\Dispatcher;
use FastRoute\RouteCollector;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use function FastRoute\simpleDispatcher;

final class FastRouteRouter implements Router
{
    private ?Dispatcher $dispatcher = null;

    private array $routes = [];

    public function addRoute(string $method, string $pattern, RequestHandlerInterface $handler): void
    {
        $this->routes[] = [$method, $pattern, $handler];
    }

    /**
     * @throws RouterException
     */
    public function match(ServerRequestInterface $serverRequest): RouteMatch
    {
        try {
            return $this->dispatchToRouter($serverRequest);
        } catch (Exception $exception) {
            throw new RouterException('Error during dispatch to router', 0, $exception);
        }
    }

    /**
     * @throws RouterException
     */
    private function dispatchToRouter(ServerRequestInterface $serverRequest): RouteMatch
    {
        $method = $serverRequest->getMethod();
        $path = $serverRequest->getUri()->getPath();

        $result = $this->buildDispatcher()->dispatch($method, $path);

        switch ($result[0]) {
            case Dispatcher::NOT_FOUND:
                return RouteMatch::fromFailure();
            case Dispatcher::METHOD_NOT_ALLOWED:
                return RouteMatch::fromFailure($result[1]);
            case Dispatcher::FOUND:
                return RouteMatch::fromSuccess($result[1], $result[2]);
            default:
                throw new RouterException('Could not handle router result');
        }
    }

    private function buildDispatcher(): Dispatcher
    {
        if ($this->dispatcher !== null) {
            return $this->dispatcher;
        }

        return simpleDispatcher(function (RouteCollector $r) {
            foreach ($this->routes as [$method, $pattern, $handler]) {
                $r->addRoute($method, $pattern, $handler);
            }
        });
    }
}
