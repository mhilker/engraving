<?php

declare(strict_types=1);

namespace Engraving\Action;

use Engraving\Template\RendererInterface;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class ErrorAction implements RequestHandlerInterface
{
    private RendererInterface $renderer;

    public function __construct(RendererInterface $renderer)
    {
        $this->renderer = $renderer;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $html = $this->renderer->render('error::500', [
            'exception' => $request->getAttribute('exception')
        ]);

        return new Response(500, ['Content-Type' => 'text/html; charset=UTF-8'], $html);
    }
}
