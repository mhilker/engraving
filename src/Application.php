<?php

declare(strict_types=1);

namespace Engraving;

use Engraving\Emitter\EmitterInterface;
use Engraving\Middleware\Pipeline\PipelineInterface;
use Psr\Http\Message\ServerRequestInterface;

final class Application
{
    private PipelineInterface $pipeline;
    private EmitterInterface $emitter;

    public function __construct(PipelineInterface $pipeline, EmitterInterface $emitter)
    {
        $this->pipeline = $pipeline;
        $this->emitter = $emitter;
    }

    public function run(ServerRequestInterface $request): void
    {
        $response = $this->pipeline->pipe($request);

        $this->emitter->emit($response);
    }
}
