<?php

declare(strict_types=1);

use Engraving\Template\Plates\Factory\PlatesRendererFactory;
use Engraving\Template\RendererInterface;
use Engraving\Template\Plates\Factory\PlatesEngineFactory;
use League\Plates\Engine;

return [
    'dependencies' => [
        'factories' => [
            RendererInterface::class => PlatesRendererFactory::class,
            Engine::class => PlatesEngineFactory::class,
        ],
    ],
    'renderer' => [
        'plates' => [
            'fileExtension' => 'phtml',
        ],
        'templates' => [],
    ],
];
