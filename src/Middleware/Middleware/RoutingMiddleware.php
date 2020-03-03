<?php

declare(strict_types=1);

namespace Engraving\Middleware\Middleware;

use Engraving\Router\RouteMatch\RouteMatchInterface;
use Engraving\Router\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class RoutingMiddleware implements MiddlewareInterface
{
    const METHOD_NOT_ALLOWED_ACTION = 'METHOD_NOT_ALLOWED_ACTION';
    const ROUTE_NOT_FOUND_ACTION = 'ROUTE_NOT_FOUND_ACTION';

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @param RouterInterface $router
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    /**
     * Process an incoming server request and return a response, optionally delegating
     * to the next middleware component to create the response.
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     *
     * @throws \Engraving\Router\Exception\RouterException
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $routeMatch = $this->router->match($request);

        $request = $this->modifyRequestAttributes($routeMatch, $request);

        return $handler->handle($request);
    }

    /**
     * Modify the request and add information from the matched route to it.
     *
     * @param RouteMatchInterface $routeMatch
     * @param ServerRequestInterface $request
     *
     * @return ServerRequestInterface
     */
    private function modifyRequestAttributes(RouteMatchInterface $routeMatch, ServerRequestInterface $request): ServerRequestInterface
    {
        if ($routeMatch->isMethodFailure() === true) {
            return $request
                ->withAttribute('actionName', self::METHOD_NOT_ALLOWED_ACTION)
                ->withAttribute('allowedMethods', $routeMatch->getAllowedMethods());
        }

        if ($routeMatch->isFailure() === true) {
            return $request->withAttribute('actionName', self::ROUTE_NOT_FOUND_ACTION);
        }

        return $request
            ->withAttribute('actionName', $routeMatch->getAction())
            ->withAttribute('parameters', $routeMatch->getParameters());
    }
}
