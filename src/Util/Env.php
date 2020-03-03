<?php

declare(strict_types=1);

namespace Engraving\Util;

final class Env
{
    public static function bool(string $key, bool $default = false): bool
    {
        if (isset($_ENV[$key]) === false) {
            return $default;
        }

        $value = strtolower(trim($_ENV[$key]));

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

    public static function int(string $key, int $default = 0): int
    {
        return isset($_ENV[$key]) ? (int) $_ENV[$key] : $default;
    }

    public static function string(string $key, string $default = ''): string
    {
        return $_ENV[$key] ?? $default;
    }
}
