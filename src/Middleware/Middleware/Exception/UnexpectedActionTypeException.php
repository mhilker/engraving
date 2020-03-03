<?php

declare(strict_types=1);

namespace Engraving\Middleware\Middleware\Exception;

use Psr\Http\Server\RequestHandlerInterface;

class UnexpectedActionTypeException extends \UnexpectedValueException implements MiddlewareException
{
    /**
     * @param mixed $item
     * @return UnexpectedActionTypeException
     */
    public static function invalidType($item): self
    {
        return new static(sprintf(
            'Actions must be an object implementing "%s", "%s given".',
            RequestHandlerInterface::class,
            is_object($item) ? get_class($item) : gettype($item)
        ));
    }
}
