<?php

/**
 * @noinspection PhpUnused
 * @noinspection UnnecessaryUseAliasInspection
 */

declare(strict_types=1);

namespace CoStack\Lib\Utility;

use CoStack\Lib\Exceptions as Exceptions;
use ReflectionException;

use function CoStack\Lib\array_filter_recursive;
use function CoStack\Lib\array_property;
use function CoStack\Lib\array_unique_keys;
use function CoStack\Lib\array_value;

/**
 * @codeCoverageIgnore
 */
class ArrayUtility
{
    /**
     * @param array<array<mixed>|int|string> $array
     * @param int $limit
     * @param callable|null $callback
     * @param int $flags
     * @return array<array<mixed>|int|string>
     */
    public static function filterRecursive(array $array, int $limit, callable $callback = null, int $flags = 0): array
    {
        return array_filter_recursive($array, $limit, $callback, $flags);
    }

    /**
     * @param array<array<mixed>> $array
     * @param string $path
     * @return array[]|mixed
     * @throws Exceptions\ArrayPathTerminatesEarlyException
     * @throws Exceptions\ArrayKeyPathDoesNotExistException
     */
    public static function value(array $array, string $path)
    {
        return array_value($array, $path);
    }

    /**
     * @param object[] $array
     * @param null|string|callable $property
     * @param null|string|callable $indexKey
     * @return mixed[]
     * @throws Exceptions\ArrayContainsNonObjectValueException
     * @throws Exceptions\PropertyMustBePropertyNameOrCallable
     * @throws ReflectionException
     */
    public function property(array $array, $property, $indexKey): array
    {
        return array_property($array, $property, $indexKey);
    }

    /**
     * @param array<mixed> ...$arrays
     * @return array<int, int|string>
     */
    public function uniqueKeys(array ...$arrays): array
    {
        return array_unique_keys($arrays);
    }
}
