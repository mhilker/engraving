<?php

declare(strict_types=1);

namespace Engraving\Middleware\Pipeline\Exception;

use Psr\Http\Server\MiddlewareInterface;

class InvalidMiddlewareException extends \InvalidArgumentException implements PipelineException
{
    /**
     * @param mixed $item
     *
     * @return InvalidMiddlewareException
     */
    public static function invalidType($item): self
    {
        return new static(sprintf(
            'Middlewares must be an object implementing "%s", "%s given".',
            MiddlewareInterface::class,
            is_object($item) ? get_class($item) : gettype($item)
        ));
    }
}
