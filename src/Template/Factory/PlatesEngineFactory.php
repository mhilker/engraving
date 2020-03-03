<?php

declare(strict_types=1);

namespace Engraving\Template\Plates\Factory;

use League\Plates\Engine;
use Psr\Container\ContainerInterface;

final class PlatesEngineFactory
{
    /**
     * @param ContainerInterface $container
     *
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     *
     * @return Engine
     */
    public function __invoke(ContainerInterface $container): Engine
    {
        $config = $container->get('config');

        $engine = $this->createEngine($config);

        return $engine;
    }

    /**
     * @param iterable $config
     *
     * @return Engine
     */
    public function createEngine(iterable $config): Engine
    {
        $fileExtension = $config['renderer']['plates']['fileExtension'] ?? null;
        $templates     = $config['renderer']['templates'] ?? [];

        $engine = new Engine();

        if ($fileExtension !== null) {
            $engine->setFileExtension($fileExtension);
        }

        foreach ($templates as $template) {
            // TODO: Check if the keys exist
            $engine->addFolder($template['name'], $template['directory']);
        }
        return $engine;
    }
}
