<?php

declare(strict_types=1);

use CoStack\Lib\Exceptions as Exceptions;

if (!function_exists('array_filter_recursive')) {
    /**
     * Filters an array the same way array_filter would, but recursively, until $limit is hit.
     *
     * @param array<array-key, (int|string|array)> $array
     * @param int $limit
     * @param callable|null $callback
     * @param int $flags
     * @return array<array-key, (int|string|array)>
     */
    function array_filter_recursive(array $array, int $limit, callable $callback = null, int $flags = 0): array
    {
        if ($limit > 1) {
            foreach ($array as $key => $value) {
                if (is_array($value)) {
                    $array[$key] = array_filter_recursive($value, $limit - 1, $callback);
                }
            }
        }
        // array_filter does not accept null as callback, despite its signature
        if (null !== $callback) {
            $array = array_filter($array, $callback, $flags);
        } else {
            $array = array_filter($array);
        }
        return $array;
    }
}

if (!function_exists('array_value')) {
    /**
     * Returns a subset of the array by walking down the keys defined in $path, separated by dots.
     *
     * @param array $array
     * @param string $path
     * @return array|mixed
     * @throws Exceptions\ArrayPathTerminatesEarlyException
     * @throws Exceptions\ArrayKeyPathDoesNotExistException
     */
    function array_value(array $array, string $path)
    {
        // Trim all chars and dots
        $path = trim($path, " \t\n\r\0\x0B.");
        if (empty($path)) {
            return $array;
        }
        $return = $array;
        // Iteration is 3 times faster than recursion
        foreach (explode('.', $path) as $key) {
            if (!is_array($return)) {
                throw new Exceptions\ArrayPathTerminatesEarlyException($path, $key, $return, $array);
            }
            // isset() first is no longer faster with PHP >= 7.4
            if (!array_key_exists($key, $return)) {
                throw new Exceptions\ArrayKeyPathDoesNotExistException($path, $key, $array);
            }
            // References are 2% slower than plain assignments
            $return = $return[$key];
        }
        return $return;
    }
}

if (!function_exists('array_property')) {
    /**
     * Like array_column, but for arrays containing objects.
     *
     * @param object[] $array
     * @param null|string|callable $property
     * @param null|string|callable $indexKey
     * @return mixed[]
     * @throws Exceptions\ObjectArrayContainsNonObjectValueException
     * @throws Exceptions\PropertyMustBePropertyNameOrCallable
     * @throws ReflectionException
     */
    function array_property(array $array, $property, $indexKey = null): array
    {
        $return = [];

        if (empty($array)) {
            return $return;
        }

        if (is_string($property)) {
            $probe = reset($array);
            /** @psalm-suppress DocblockTypeContradiction */
            if (!is_object($probe)) {
                throw new Exceptions\ObjectArrayContainsNonObjectValueException($probe, $array);
            }
            $reflection = new ReflectionProperty($probe, $property);

            if ($reflection->isPublic()) {
                foreach ($array as $object) {
                    $return[] = $object->{$property};
                }
                if (null !== $indexKey) {
                    $return = array_combine(array_property($array, $indexKey), $return);
                }
                return $return;
            }

            // Accessible reflection is 2 times slower than direct access
            // but 2 times faster than using closures at all
            // and 4 times faster than rebinding closures
            $reflection->setAccessible(true);

            foreach ($array as $object) {
                $return[] = $reflection->getValue($object);
            }
            return $return;
        }

        if (is_callable($property)) {
            foreach ($array as $object) {
                $return[] = $property($object);
            }
            if (null !== $indexKey) {
                $return = array_combine(array_property($array, $indexKey), $return);
            }
            return $return;
        }

        /** @psalm-suppress RedundantConditionGivenDocblockType */
        if (null === $property && null !== $indexKey) {
            return array_combine(array_property($array, $indexKey), $array);
        }

        throw new Exceptions\PropertyMustBePropertyNameOrCallable($property, $array);
    }
}
