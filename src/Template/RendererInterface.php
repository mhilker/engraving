<?php

declare(strict_types=1);

namespace Engraving\Template;

use Engraving\Template\Exception\RendererException;

interface RendererInterface
{
    /**
     * Renders the given template and returns the rendered version as plain text.
     *
     * @param string $template
     * @param iterable $variables
     *
     * @throws RendererException
     *
     * @return string
     */
    public function render(string $template, iterable $variables): string;
}
