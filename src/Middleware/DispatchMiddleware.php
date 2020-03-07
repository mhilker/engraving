<?php

declare(strict_types=1);

namespace Engraving\Middleware;

use Engraving\Middleware\Exception\UnexpectedActionTypeException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class DispatchMiddleware implements MiddlewareInterface
{
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $action = $request->getAttribute('handler');

        if (($action instanceof RequestHandlerInterface) === false) {
            throw UnexpectedActionTypeException::invalidType($action);
        }

        return $action->handle($request);
    }
}
