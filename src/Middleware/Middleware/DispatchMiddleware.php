<?php

declare(strict_types=1);

namespace Engraving\Middleware\Middleware;

use Engraving\Middleware\Middleware\Exception\UnexpectedActionTypeException;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class DispatchMiddleware implements MiddlewareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Process an incoming server request and return a response, optionally delegating
     * to the next middleware component to create the response.
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return ResponseInterface
     */
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
