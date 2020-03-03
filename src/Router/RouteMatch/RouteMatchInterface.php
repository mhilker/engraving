<?php

declare(strict_types=1);

namespace Engraving\Router\RouteMatch;

interface RouteMatchInterface
{
    public function isSuccess(): bool;

    public function isFailure(): bool;

    public function isMethodFailure(): bool;

    public function getAction(): string;

    public function getParameters(): iterable;

    public function getAllowedMethods(): iterable;
}
