<?php

declare(strict_types=1);

namespace Engraving\Router;

use Engraving\Router\Exception\RouterException;
use Psr\Http\Server\RequestHandlerInterface;

final class RouteMatch
{
    private bool $success = false;

    private ?RequestHandlerInterface $handler = null;

    private ?iterable $parameters = null;

    private ?iterable $allowedMethods = null;

    private function __construct()
    {
    }

    public static function fromSuccess(RequestHandlerInterface $handler, iterable $parameters): self
    {
        $routeMatch = new RouteMatch();
        $routeMatch->success = true;
        $routeMatch->handler = $handler;
        $routeMatch->parameters = $parameters;

        return $routeMatch;
    }

    public static function fromFailure(iterable $allowedMethods = null): self
    {
        $routeMatch = new RouteMatch();
        $routeMatch->success = false;

        if ($allowedMethods !== null) {
            $routeMatch->allowedMethods = $allowedMethods;
        }

        return $routeMatch;
    }

    public function isSuccess(): bool
    {
        return $this->success === true;
    }

    public function isFailure(): bool
    {
        return $this->success === false;
    }

    public function isMethodFailure(): bool
    {
        return $this->success === false && is_iterable($this->allowedMethods);
    }

    /**
     * @throws RouterException
     */
    public function getHandler(): RequestHandlerInterface
    {
        if ($this->isSuccess() === false) {
            throw new RouterException('Unable to get request handler from failed route match.');
        }

        return $this->handler;
    }

    /**
     * @throws RouterException
     */
    public function getParameters(): iterable
    {
        if ($this->isSuccess() === false) {
            throw new RouterException('Unable to get parameters from failed route match.');
        }

        return $this->parameters;
    }

    /**
     * @throws RouterException
     */
    public function getAllowedMethods(): iterable
    {
        if ($this->isMethodFailure() === false) {
            throw new RouterException('Unable to get allowed methods from route match without method failure.');
        }

        return $this->allowedMethods;
    }
}
