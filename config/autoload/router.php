<?php

declare(strict_types=1);

use Engraving\Util\Env;
use Engraving\Router\FastRoute\Factory\FastRouteRouterFactory;
use Engraving\Router\RouterInterface;

return [
    'dependencies' => [
        'factories' => [
            RouterInterface::class => FastRouteRouterFactory::class,
        ],
    ],
    'router' => [
        'fastroute' => [
            'cacheDisabled' => Env::bool('CACHE_ENABLED', false) === false,
            'cacheFile'     => __DIR__ . '/../../cache/fastroute.cache.php',
        ],
        'routes' => [],
    ],
];
