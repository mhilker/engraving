<?php

declare(strict_types=1);

namespace Engraving\Router;

use Engraving\Router\RouteMatch\RouteMatchInterface;
use Psr\Http\Message\ServerRequestInterface;

interface RouterInterface
{
    public function match(ServerRequestInterface $serverRequest): RouteMatchInterface;
}
