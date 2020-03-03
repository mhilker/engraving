<?php

declare(strict_types=1);

namespace Engraving\Router\FastRoute;

use Engraving\Router\Exception\RouterException;
use Engraving\Router\FastRoute\Exception\LogicException;
use Engraving\Router\RouteMatch\RouteMatch;
use Engraving\Router\RouteMatch\RouteMatchInterface;
use Engraving\Router\RouterInterface;
use FastRoute\Dispatcher;
use Psr\Http\Message\ServerRequestInterface;

class FastRouteRouter implements RouterInterface
{
    /**
     * @var Dispatcher
     */
    private $dispatcher;

    /**
     * @param Dispatcher $dispatcher
     */
    public function __construct(Dispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * Try to match the given $serverRequest and return a RouteMatch.
     *
     * @param ServerRequestInterface $serverRequest
     *
     * @throws RouterException
     *
     * @return RouteMatchInterface
     */
    public function match(ServerRequestInterface $serverRequest): RouteMatchInterface
    {
        try {
            return $this->dispatchToRouter($serverRequest);
        } catch (\Exception $exception) {
            // TODO: add specific exception
            throw new \Exception('Error during dispatch to router.', 0, $exception);
        }
    }

    /**
     * @param ServerRequestInterface $serverRequest
     *
     * @throws LogicException
     *
     * @return RouteMatch
     */
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
