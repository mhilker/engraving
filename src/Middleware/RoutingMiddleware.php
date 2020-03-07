<?php

declare(strict_types=1);

namespace Engraving\Middleware;

use Engraving\Router\Router;
use Engraving\Template\Renderer;
use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class RoutingMiddleware implements MiddlewareInterface
{
    private Router $router;
    private Renderer $renderer;

    public function __construct(Router $router, Renderer $renderer)
    {
        $this->router = $router;
        $this->renderer = $renderer;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $routeMatch = $this->router->match($request);

        if ($routeMatch->isFailure() === true) {
            $html = $this->renderer->render('error-404');
            return new Response(404, ['Content-Type' => 'text/html; charset=UTF-8'], $html);
        }

        if ($routeMatch->isMethodFailure() === true) {
            $html = $this->renderer->render('error-405');
            return new Response(405, ['Content-Type' => 'text/html; charset=UTF-8'], $html);
        }

        $request = $request
            ->withAttribute('handler', $routeMatch->getHandler())
            ->withAttribute('parameters', $routeMatch->getParameters());

        return $handler->handle($request);
    }
}
