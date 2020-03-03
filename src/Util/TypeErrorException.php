<?php

declare(strict_types=1);

namespace Engraving\Util;

use Exception;

final class TypeErrorException extends Exception
{
    public static function invalidType($value, string $expectedType): self
    {
        return new self(sprintf(
            'Environment variable has invalid type, expected "%s" but type "%s" with value "%s" given.',
            $expectedType,
            is_object($value) ? get_class($value) : gettype($value),
            $value
        ));
    }
}
