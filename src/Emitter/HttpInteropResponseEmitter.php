<?php

declare(strict_types=1);

namespace Engraving\Emitter;

use Psr\Http\Message\ResponseInterface;

use function Http\Response\send;

final class HttpInteropResponseEmitter implements ResponseEmitter
{
    public function emit(ResponseInterface $response): void
    {
        send($response);
    }
}
