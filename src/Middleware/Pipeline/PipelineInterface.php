<?php

declare(strict_types=1);

namespace Engraving\Middleware\Pipeline;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface PipelineInterface
{
    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function pipe(ServerRequestInterface $request): ResponseInterface;
}
