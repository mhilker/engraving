<?php

declare(strict_types=1);

namespace Engraving\Router;

use Engraving\Router\FastRoute\Exception\LogicException;
use Engraving\Router\RouteMatch\RouteMatch;
use Engraving\Router\RouteMatch\RouteMatchInterface;
use Exception;
use FastRoute\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;

final class FastRouteRouter implements RouterInterface
{
    private Dispatcher $dispatcher;

    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    public function match(ServerRequestInterface $serverRequest): RouteMatchInterface
    {
        try {
            return $this->dispatchToRouter($serverRequest);
        } catch (Exception $exception) {
            // TODO: add specific exception
            throw new Exception('Error during dispatch to router.', 0, $exception);
        }
    }

    private function dispatchToRouter(ServerRequestInterface $serverRequest): RouteMatch
    {
        $method = $serverRequest->getMethod();
        $path = $serverRequest->getUri()->getPath();

        $routeInfo = $this->dispatcher->dispatch($method, $path);

        switch ($routeInfo[0]) {
            case Dispatcher::NOT_FOUND:
                return RouteMatch::fromFailure();

            case Dispatcher::METHOD_NOT_ALLOWED:
                return RouteMatch::fromFailure($routeInfo[1]);

            case Dispatcher::FOUND:
                return RouteMatch::fromSuccess($routeInfo[1], $routeInfo[2]);
        }

        throw new LogicException('This instruction should not be reached.');
    }
}
