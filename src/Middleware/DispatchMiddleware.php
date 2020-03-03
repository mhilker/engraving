<?php

declare(strict_types=1);

namespace Engraving\Middleware;

use Engraving\Middleware\Exception\UnexpectedActionTypeException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class DispatchMiddleware implements MiddlewareInterface
{
    private ContainerInterface $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $actionName = $request->getAttribute('actionName');

        // TODO: use a specific container and enforce type checking
        $action = $this->container->get($actionName);

        if (($action instanceof RequestHandlerInterface) === false) {
            throw UnexpectedActionTypeException::invalidType($action);
        }

        return $action->handle($request);
    }
}
