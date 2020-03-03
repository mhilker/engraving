<?php

declare(strict_types=1);

namespace Engraving\Emitter;

use Psr\Http\Message\ResponseInterface;

use function Http\Response\send;

class HttpInteropEmitter implements EmitterInterface
{
    public function emit(ResponseInterface $response): void
    {
        send($response);
    }
}
