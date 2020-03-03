<?php

declare(strict_types=1);

namespace Engraving\Router\FastRoute\Exception;

use Engraving\Router\Exception\RouterException;

class ConfigurationException extends \InvalidArgumentException implements RouterException
{
    /**
     * @param mixed $value
     *
     * @return ConfigurationException
     */
    public static function invalidOptions($value): self
    {
        return new static(sprintf(
            'The fastroute options must be an iterable, "%s" given.',
            is_object($value) ? get_class($value) : gettype($value)
        ));
    }

    /**
     * @param mixed $value
     *
     * @return ConfigurationException
     */
    public static function invalidRoutes($value): self
    {
        return new static(sprintf(
            'The fastroute routes must an iterable, "%s" given.',
            is_object($value) ? get_class($value) : gettype($value)
        ));
    }
}
