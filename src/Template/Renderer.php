<?php

declare(strict_types=1);

namespace Engraving\Template;

use Engraving\Template\Exception\RendererException;

interface Renderer
{
    /**
     * @throws RendererException
     */
    public function render(string $template, array $variables = []): string;
}
