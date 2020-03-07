<?php

declare(strict_types=1);

namespace Engraving\Pipeline;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;

interface Pipeline
{
    public function addMiddleware(MiddlewareInterface $middleware): void;

    public function pipe(ServerRequestInterface $request): ResponseInterface;
}
