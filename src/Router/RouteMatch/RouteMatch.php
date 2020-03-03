<?php

declare(strict_types=1);

namespace Engraving\Router\RouteMatch;

use Engraving\Router\Exception\BadMethodCallException;

final class RouteMatch implements RouteMatchInterface
{
    private bool $success = false;

    private ?string $action = null;

    private ?iterable $parameters = null;

    private ?iterable $allowedMethods = null;

    private function __construct()
    {
    }

    public static function fromSuccess(string $action, iterable $parameters): self
    {
        $routeMatch = new RouteMatch();
        $routeMatch->success = true;
        $routeMatch->action = $action;
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

    public function getAction(): string
    {
        if ($this->isSuccess() === false) {
            throw new BadMethodCallException('Unable to get action from failed route match.');
        }

        return $this->action;
    }

    public function getParameters(): iterable
    {
        if ($this->isSuccess() === false) {
            throw new BadMethodCallException('Unable to get parameters from failed route match.');
        }

        return $this->parameters;
    }

    public function getAllowedMethods(): iterable
    {
        if ($this->isMethodFailure() === false) {
            throw new BadMethodCallException('Unable to get allowed methods from route match without method failure.');
        }

        return $this->allowedMethods;
    }
}
