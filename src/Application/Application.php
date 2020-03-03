<?php

declare(strict_types=1);

namespace Engraving\Application;

use Engraving\Emitter\EmitterInterface;
use Engraving\Middleware\Pipeline\PipelineInterface;
use Psr\Http\Message\ServerRequestInterface;

class Application
{
    /**
     * @var PipelineInterface
     */
    private $pipeline;

    /**
     * @var EmitterInterface
     */
    private $emitter;

    /**
     * @param PipelineInterface $pipeline
     * @param EmitterInterface $emitter
     */
    public function __construct(PipelineInterface $pipeline, EmitterInterface $emitter)
    {
        $this->pipeline = $pipeline;
        $this->emitter = $emitter;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return void
     */
    public function run(ServerRequestInterface $request): void
    {
        $response = $this->pipeline->pipe($request);

        $this->emitter->emit($response);
    }
}
