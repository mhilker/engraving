<?php

declare(strict_types=1);

namespace Engraving\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

final class ExceptionMiddleware implements MiddlewareInterface
{
    public const EXCEPTION_ACTION = 'EXCEPTION_ACTION';

    private RequestHandlerInterface $errorHandler;

    public function __construct(RequestHandlerInterface $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $response = $handler->handle($request);
        } catch (Throwable $exception) {
            $request = $request->withAttribute('exception', $exception);
            $response = $this->errorHandler->handle($request);
        }

        return $response;
    }
}
