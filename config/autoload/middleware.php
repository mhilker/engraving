<?php

declare(strict_types=1);

use App\Middleware\WhoopsMiddleware;
use Engraving\Middleware\DispatchMiddleware;
use Engraving\Middleware\ExceptionMiddleware;
use Engraving\Middleware\Factory\DispatchMiddlewareFactory;
use Engraving\Middleware\Factory\ExceptionMiddlewareFactory;
use Engraving\Middleware\Factory\RoutingMiddlewareFactory;
use Engraving\Middleware\RoutingMiddleware;
use Engraving\Middleware\Pipeline\Factory\QueuePipelineFactory;
use Engraving\Middleware\Pipeline\PipelineInterface;
use Engraving\Util\Env;

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
            Env::bool('DEBUG_ENABLED', false) ? ([
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
