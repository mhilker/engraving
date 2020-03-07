<?php

declare(strict_types=1);

namespace Engraving\Template;

use Engraving\Template\Exception\RendererException;
use Exception;
use League\Plates\Engine;

final class PlatesRenderer implements Renderer
{
    private Engine $plates;

    public function __construct(Engine $plates)
    {
        $this->plates = $plates;
    }

    /**
     * @throws RendererException
     */
    public function render(string $template, array $variables = []): string
    {
        try {
            return $this->plates->render($template, $variables);
        } catch (Exception $exception) {
            throw RendererException::withPrevious($template, $exception);
        }
    }
}
