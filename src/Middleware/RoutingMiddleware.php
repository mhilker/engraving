<?php

declare(strict_types=1);

namespace Engraving\Middleware;

use Engraving\Router\RouteMatch\RouteMatchInterface;
use Engraving\Router\RouterInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RoutingMiddleware implements MiddlewareInterface
{
    public const METHOD_NOT_ALLOWED_ACTION = 'METHOD_NOT_ALLOWED_ACTION';
    public const ROUTE_NOT_FOUND_ACTION = 'ROUTE_NOT_FOUND_ACTION';

    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $routeMatch = $this->router->match($request);

        $request = $this->modifyRequestAttributes($routeMatch, $request);

        return $handler->handle($request);
    }

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
