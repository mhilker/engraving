<?php

declare(strict_types=1);

namespace Engraving\Middleware;

use Engraving\Template\Renderer;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

final class ExceptionMiddleware implements MiddlewareInterface
{
    private Renderer $renderer;

    public function __construct(Renderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            return $handler->handle($request);
        } catch (Throwable $exception) {
            return $this->handleException($exception);
        }
    }

    protected function handleException($exception): Response
    {
        $html = $this->renderer->render('error-500', [
            'exception' => $exception,
        ]);
        return new Response(500, ['Content-Type' => 'text/html; charset=UTF-8'], $html);
    }
}
