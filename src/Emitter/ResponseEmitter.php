<?php

declare(strict_types=1);

namespace Engraving\Emitter;

use Psr\Http\Message\ResponseInterface;

interface ResponseEmitter
{
    public function emit(ResponseInterface $response): void;
}
