<?php

declare(strict_types=1);

namespace Engraving\Util;

use Engraving\Exception\TypeErrorException;

class Env
{
    /**
     * @param string $key
     * @param bool $default
     *
     * @throws TypeErrorException
     *
     * @return bool
     */
    public static function bool(string $key, bool $default = false): bool
    {
        if (isset($_ENV[$key]) === false) {
            return $default;
        }

        $value = trim(strtolower($_ENV[$key]));

        switch ($value) {
            case '1':
            case 'true':
                return true;
            case '':
            case '0':
            case 'false':
                return false;
        }

        throw TypeErrorException::invalidType($value, 'boolean');
    }

    /**
     * @param string $key
     * @param int $default
     *
     * @return int
     */
    public static function int(string $key, int $default = 0): int
    {
        return $_ENV[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param string $default
     *
     * @return string
     */
    public static function string(string $key, string $default = ''): string
    {
        return $_ENV[$key] ?? $default;
    }
}
