<?php

declare(strict_types=1);

namespace Engraving\Emitter;

use Psr\Http\Message\ResponseInterface;

class EchoEmitter implements EmitterInterface
{
    /**
     * Emit the response.
     *
     * @param ResponseInterface $response
     *
     * @return void
     */
    public function emit(ResponseInterface $response): void
    {
        // Emit http status code
        echo sprintf(
            'HTTP/%s %s %s',
            $response->getProtocolVersion(),
            $response->getStatusCode(),
            $response->getReasonPhrase()
        ) . PHP_EOL;

        // Emit headers iteratively
        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                echo sprintf('%s: %s', $name, $value) . PHP_EOL;
            }
        }

        // End the headers
        echo PHP_EOL;

        // Emit body
        echo $response->getBody();
    }
}
