<?php

declare(strict_types=1);

use Engraving\Application\Application;
use Engraving\Application\Factory\ApplicationFactory;
use Engraving\Container\Factory\InvokableFactory;
use Engraving\Emitter\EmitterInterface;
use Engraving\Emitter\HttpInteropEmitter;

return [
    'dependencies' => [
        'factories' => [
            Application::class => ApplicationFactory::class,
            HttpInteropEmitter::class => InvokableFactory::class,
        ],
        'aliases' => [
            EmitterInterface::class => HttpInteropEmitter::class,
        ],
    ],
];
