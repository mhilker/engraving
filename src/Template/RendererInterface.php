<?php

declare(strict_types=1);

namespace Engraving\Template;

interface RendererInterface
{
    public function render(string $template, array $variables): string;
}
