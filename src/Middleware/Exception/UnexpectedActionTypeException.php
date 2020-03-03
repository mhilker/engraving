<?php

declare(strict_types=1);

namespace Engraving\Middleware\Exception;

use Psr\Http\Server\RequestHandlerInterface;
use UnexpectedValueException;

final class UnexpectedActionTypeException extends UnexpectedValueException implements MiddlewareException
{
    public static function invalidType($item): self
    {
        return new static(sprintf(
            'Actions must be an object implementing "%s", "%s given".',
            RequestHandlerInterface::class,
            is_object($item) ? get_class($item) : gettype($item)
        ));
    }
}
