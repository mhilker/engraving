<?php

declare(strict_types=1);

namespace Engraving\Router\FastRoute\Exception;

use Engraving\Router\Exception\RouterException;
use Exception;

final class ConfigurationException extends Exception implements RouterException
{
    public static function invalidOptions($value): self
    {
        return new static(sprintf(
            'The fastroute options must be an iterable, "%s" given.',
            is_object($value) ? get_class($value) : gettype($value)
        ));
    }

    public static function invalidRoutes($value): self
    {
        return new static(sprintf(
            'The fastroute routes must an iterable, "%s" given.',
            is_object($value) ? get_class($value) : gettype($value)
        ));
    }
}
