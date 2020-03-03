<?php

declare(strict_types=1);

namespace Engraving\Template\Plates;

use Engraving\Template\Exception\RendererEngineException;
use Engraving\Template\RendererInterface;
use League\Plates\Engine;

final class PlatesRenderer implements RendererInterface
{
    /**
     * @var Engine
     */
    private $platesEngine;

    /**
     * @param Engine $platesEngine
     */
    public function __construct(Engine $platesEngine)
    {
        $this->platesEngine = $platesEngine;
    }

    /**
     * @param string $template
     * @param iterable $variables
     *
     * @throws RendererEngineException
     *
     * @return string
     */
    public function render(string $template, iterable $variables): string
    {
        try {
            return $this->platesEngine->render($template, $variables);
        } catch (\Exception $exception) {
            throw RendererEngineException::withPrevious($template, $exception);
        }
    }
}
