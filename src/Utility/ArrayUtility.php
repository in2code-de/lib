<?php

declare(strict_types=1);

namespace CoStack\Lib\Utility;

use function array_filter_recursive;

/**
 * @codeCoverageIgnore
 */
class ArrayUtility
{
    /**
     * @param array<array-key, (int|string|array)> $array
     * @param int $limit
     * @param callable|null $callback
     * @param int $flags
     * @return array<array-key, (int|string|array)>
     */
    public static function filterRecursive(array $array, int $limit, callable $callback = null, int $flags = 0): array
    {
        return array_filter_recursive($array, $limit, $callback, $flags);
    }
}
