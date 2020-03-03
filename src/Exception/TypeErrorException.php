<?php

declare(strict_types=1);

namespace Engraving\Exception;

class TypeErrorException extends \Exception
{
    /**
     * @param mixed $value
     * @param string $expectedType
     *
     * @return TypeErrorException
     */
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
