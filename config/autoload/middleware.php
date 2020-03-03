<?php

declare(strict_types=1);

use App\Middleware\WhoopsMiddleware;
use Engraving\Middleware\Middleware\DispatchMiddleware;
use Engraving\Middleware\Middleware\ExceptionMiddleware;
use Engraving\Middleware\Middleware\Factory\DispatchMiddlewareFactory;
use Engraving\Middleware\Middleware\Factory\ExceptionMiddlewareFactory;
use Engraving\Middleware\Middleware\Factory\RoutingMiddlewareFactory;
use Engraving\Middleware\Middleware\RoutingMiddleware;
use Engraving\Middleware\Pipeline\Factory\QueuePipelineFactory;
use Engraving\Middleware\Pipeline\PipelineInterface;

return [
    'dependencies' => [
        'factories' => [
            // Pipeline
            PipelineInterface::class => QueuePipelineFactory::class,

            // Middlewares
            ExceptionMiddleware::class => ExceptionMiddlewareFactory::class,
            RoutingMiddleware::class => RoutingMiddlewareFactory::class,
            DispatchMiddleware::class => DispatchMiddlewareFactory::class,
        ],
    ],
    'middleware' => [
        'pipeline' => array_merge_recursive(
            \Engraving\Util\Env::bool('DEBUG_ENABLED', false) ? ([
                [
                    'name' => WhoopsMiddleware::class,
                ]
            ]) : ([
                [
                    'name' => ExceptionMiddleware::class,
                ]
            ]),
            [
                [
                    'name' => RoutingMiddleware::class,
                ],
                [
                    'name' => DispatchMiddleware::class,
                ],
            ]
        ),
    ],
];
