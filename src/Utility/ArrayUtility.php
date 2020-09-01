<?php

declare(strict_types=1);

namespace CoStack\Lib\Utility;

use CoStack\Lib\Exceptions as Exceptions;

use function array_filter_recursive;
use function array_value;

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

    /**
     * @param array[] $array
     * @param string $path
     * @return array[]|mixed
     * @throws Exceptions\ArrayPathTerminatesEarlyException
     * @throws Exceptions\ArrayKeyPathDoesNotExistException
     */
    public static function value(array $array, string $path)
    {
        return array_value($array, $path);
    }
}
