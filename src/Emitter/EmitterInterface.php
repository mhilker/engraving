<?php

declare(strict_types=1);

namespace Engraving\Emitter;

use Psr\Http\Message\ResponseInterface;

interface EmitterInterface
{
    /**
     * Emit the response.
     *
     * @param ResponseInterface $response
     *
     * @return void
     */
    public function emit(ResponseInterface $response): void;
}
