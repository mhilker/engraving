<?php

declare(strict_types=1);

namespace Engraving\Template\Exception;

use Exception;

final class RendererException extends Exception
{
    public static function withPrevious(string $template, Exception $exception): self
    {
        return new static(sprintf('Error during rendering of template "%s".', $template), 0, $exception);
    }
}
