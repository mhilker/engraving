<?php

declare(strict_types=1);

namespace Engraving\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Whoops\Handler\PrettyPageHandler;
use Whoops\Run;

final class WhoopsMiddleware implements MiddlewareInterface
{
    public function __construct()
    {
        if (class_exists(Run::class)) {
            $whoops = new Run();
            $whoops->pushHandler(new PrettyPageHandler());
            $whoops->register();
        }
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        return $handler->handle($request);
    }
}
