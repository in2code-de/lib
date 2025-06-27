<?php

declare(strict_types=1);

namespace CoStack\Lib\Utility;

class StringPool
{
    /**
     * @var array<string, string>
     */
    private static array $strings = [];

    public static function get(string $string): string
    {
        return self::$strings[$string] ??= $string;
    }

    public static function flush(): void
    {
        self::$strings = [];
    }
}
