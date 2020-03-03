<?php

declare(strict_types=1);

namespace Engraving\Template\Plates\Factory;

use Engraving\Template\Plates\PlatesRenderer;
use League\Plates\Engine;
use Psr\Container\ContainerInterface;

final class PlatesRendererFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return PlatesRenderer
     */
    public function __invoke(ContainerInterface $container): PlatesRenderer
    {
        $engine = $container->get(Engine::class);

        return new PlatesRenderer($engine);
    }
}
