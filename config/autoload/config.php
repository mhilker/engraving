<?php

declare(strict_types=1);

use App\Action\Factory\ErrorActionFactory;
use App\Action\Factory\IndexActionFactory;
use App\Action\Factory\MethodNotAllowedActionFactory;
use App\Action\Factory\RouteNotFoundActionFactory;
use App\Action\IndexAction;
use App\Middleware\WhoopsMiddleware;
use Engraving\Container\Factory\InvokableFactory;
use Engraving\Middleware\Middleware\ExceptionMiddleware;
use Engraving\Middleware\Middleware\RoutingMiddleware;

return [
    'dependencies' => [
        'factories' => [
            // Application Actions
            IndexAction::class => IndexActionFactory::class,

            // Error Actions
            RoutingMiddleware::METHOD_NOT_ALLOWED_ACTION => MethodNotAllowedActionFactory::class,
            RoutingMiddleware::ROUTE_NOT_FOUND_ACTION    => RouteNotFoundActionFactory::class,
            ExceptionMiddleware::EXCEPTION_ACTION        => ErrorActionFactory::class,

            // Middlewares
            WhoopsMiddleware::class => InvokableFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            [
                'method'  => 'GET',
                'route'   => '/',
                'handler' => IndexAction::class,
            ],
        ],
    ],
    'renderer' => [
        'templates' => [
            [
                'directory' => __DIR__ . '/../view/app',
                'name'      => 'app',
            ],
            [
                'directory' => __DIR__ . '/../view/error',
                'name'      => 'error',
            ],
            [
                'directory' => __DIR__ . '/../view/layout',
                'name'      => 'layout',
            ],
        ],
    ],
];
