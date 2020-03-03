<?php

declare(strict_types=1);

namespace Engraving\Middleware\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ExceptionMiddleware implements MiddlewareInterface
{
    const EXCEPTION_ACTION = 'EXCEPTION_ACTION';

    /**
     * @var RequestHandlerInterface
     */
    private $errorHandler;

    /**
     * @param RequestHandlerInterface $errorHandler
     */
    public function __construct(RequestHandlerInterface $errorHandler)
    {
        $this->errorHandler = $errorHandler;
    }

    /**
     * Process an incoming server request and return a response, optionally delegating
     * to the next middleware component to create the response.
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $response = $handler->handle($request);
        } catch (\Throwable $exception) {
            $request = $request->withAttribute('exception', $exception);
            $response = $this->errorHandler->handle($request);
        }

        return $response;
    }
}
