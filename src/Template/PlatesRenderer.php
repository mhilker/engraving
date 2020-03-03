<?php

declare(strict_types=1);

namespace Engraving\Template;

use Engraving\Template\Exception\RendererEngineException;
use Exception;
use League\Plates\Engine;

final class PlatesRenderer implements RendererInterface
{
    private Engine $platesEngine;

    public function __construct(Engine $platesEngine)
    {
        $this->platesEngine = $platesEngine;
    }

    public function render(string $template, array $variables): string
    {
        try {
            return $this->platesEngine->render($template, $variables);
        } catch (Exception $exception) {
            throw RendererEngineException::withPrevious($template, $exception);
        }
    }
}
