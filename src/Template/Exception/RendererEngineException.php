<?php

declare(strict_types=1);

namespace Engraving\Template\Exception;

class RendererEngineException extends \Exception implements RendererException
{
    /**
     * @param string $template
     * @param \Exception $exception
     *
     * @return RendererEngineException
     */
    public static function withPrevious(string $template, \Exception $exception): self
    {
        return new static(sprintf('Error during rendering of template "%s".', $template), 0, $exception);
    }
}
