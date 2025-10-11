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
use function CoStack\Lib\enumerate;

/**
 * @codeCoverageIgnore
 */
class ArrayUtility
{
    /**
     * @param array<array<mixed>|int|string> $array
     * @param callable|null $callback
     * @return array<array<mixed>|int|string>
     */
    public static function filterRecursive(array $array, int $limit, ?callable $callback = null, int $flags = 0): array
    {
        return array_filter_recursive($array, $limit, $callback, $flags);
    }

    /**
     * @param array<array<mixed>> $array
     * @return array<array>|mixed
     * @throws Exceptions\ArrayPathTerminatesEarlyException
     * @throws Exceptions\ArrayKeyPathDoesNotExistException
     */
    public static function value(array $array, string $path): mixed
    {
        return array_value($array, $path);
    }

    /**
     * @param array<object> $array
     * @param null|string|callable $property
     * @param null|string|callable $indexKey
     * @return array<mixed>
     * @throws Exceptions\ArrayContainsNonObjectValueException
     * @throws Exceptions\PropertyMustBePropertyNameOrCallable
     * @throws ReflectionException
     */
    public function property(
        array $array,
        null|string|callable $property,
        null|string|callable $indexKey,
    ): array {
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

    /**
     * @param string $glue The glue for the last element. Most of the time "and" in the target language.
     * @param array<string> $strings Array of strings that will be imploded
     * @param bool $oxfordComma Add a comma before the last element in lists of elements >= 3
     * @return string The concatenated parts of $strings
     * @SuppressWarnings("PHPMD.BooleanArgumentFlag")
     */
    public static function enumerate(string $glue, array $strings, bool $oxfordComma = false): string
    {
        return enumerate($glue, $strings, $oxfordComma);
    }
}
