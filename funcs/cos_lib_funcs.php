<?php

declare(strict_types=1);

namespace CoStack\Lib;

use Closure;
use CoStack\Lib\Exceptions;
use Exception;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionProperty;

use function define;
use function is_array;
use function is_callable;
use function str_replace;

if (!function_exists('\CoStack\Lib\array_filter_recursive')) {
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

if (!function_exists('\CoStack\Lib\array_value')) {
    /**
     * Returns a subset of the array by walking down the keys defined in $path, separated by dots.
     *
     * @param array $array
     * @param string $path
     * @return mixed
     * @throws Exceptions\ArrayPathTerminatesEarlyException
     * @throws Exceptions\ArrayKeyPathDoesNotExistException
     */
    function array_value(array $array, string $path): mixed
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

if (!function_exists('\CoStack\Lib\array_property')) {
    /**
     * Like array_column, but for arrays containing objects.
     *
     * @param object[] $array
     * @param null|string|callable $property
     * @param null|string|callable $indexKey
     * @return mixed[]
     * @throws Exceptions\ArrayContainsNonObjectValueException
     * @throws Exceptions\PropertyMustBePropertyNameOrCallable
     * @throws ReflectionException
     */
    function array_property(array $array, null|string|callable $property, null|string|callable $indexKey = null): array
    {
        $return = [];

        if (empty($array)) {
            return $return;
        }

        if (is_string($property)) {
            $probe = reset($array);
            /** @psalm-suppress DocblockTypeContradiction */
            if (!is_object($probe)) {
                throw new Exceptions\ArrayContainsNonObjectValueException($probe, $array);
            }
            $reflection = new ReflectionProperty($probe, $property);

            if ($reflection->isPublic()) {
                // Use array_column on public properties. It's 5 times faster than iterative property access.
                $return = array_column($array, $property);
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

        if (null !== $indexKey) {
            return array_combine(array_property($array, $indexKey), $array);
        }

        throw new Exceptions\PropertyMustBePropertyNameOrCallable($property, $array);
    }
}

if (!function_exists('\CoStack\Lib\concat_paths')) {
    /**
     * Concatenate filesystem paths
     *
     * @param string ...$paths
     * @return string
     */
    function concat_paths(string ...$paths): string
    {
        $doubleDs = DIRECTORY_SEPARATOR . DIRECTORY_SEPARATOR;
        switch (count($paths)) {
            case 0:
                return '';
            case 1:
                return str_replace($doubleDs, DIRECTORY_SEPARATOR, $paths[0]);
            default:
                $first = $paths[0];
                unset($paths[0]);
                $prefix = '';
                $prefixPos = strpos($first, '://');
                if (false !== $prefixPos) {
                    $prefix = substr($first, 0, $prefixPos + 3);
                    $first = substr($first, $prefixPos + 3);
                }

                $full = $first;
                foreach ($paths as $path) {
                    if (!empty($full)) {
                        $full .= DIRECTORY_SEPARATOR;
                    }

                    $full .= $path;
                }
                while (str_contains($full, $doubleDs)) {
                    $full = str_replace($doubleDs, DIRECTORY_SEPARATOR, $full);
                }
                return $prefix . $full;
        }
    }
}

if (!function_exists('\CoStack\Lib\mkdir_deep')) {
    /**
     * Create a directory recursively without need to pass the mode argument.
     * The default mode is *not* always 0777, as defined in the signature, because it is modified globally by umask().
     *
     * @param string $path
     * @param int|null $mode
     * @return bool
     */
    function mkdir_deep(string $path, int $mode = null): bool
    {
        if (is_dir($path)) {
            return true;
        }
        if (!mkdir_deep(dirname($path), $mode)) {
            // @codeCoverageIgnoreStart
            return false;
            // @codeCoverageIgnoreEnd
        }
        if (null !== $mode) {
            return mkdir($path, $mode);
        }
        return mkdir($path);
    }
}

if (!function_exists('\CoStack\Lib\factory')) {
    /**
     * Creates a new instance of a class with constructor arguments provided as an associative array
     *
     * @template T
     * @psalm-param class-string<T> $class
     * @param string $class
     * @param mixed[] $arguments
     * @psalm-return T
     * @return object
     *
     * @throws Exceptions\MissingConstructorArgumentException
     * @throws Exceptions\MissingPropertyOrConstructorArgumentException
     * @throws Exceptions\PropertyNotPublicException
     * @throws ReflectionException
     */
    function factory(string $class, array $arguments = []): object
    {
        $reflectionClass = new ReflectionClass($class);
        $constructorArgs = [];

        $constructor = $reflectionClass->getConstructor();

        if (null !== $constructor) {
            foreach ($constructor->getParameters() as $reflectionParameter) {
                $position = $reflectionParameter->getPosition();
                $name = $reflectionParameter->getName();

                if (!isset($arguments[$name])) {
                    if ($reflectionParameter->isOptional()) {
                        $constructorArgs[$position] = $reflectionParameter->getDefaultValue();
                    } else {
                        throw new Exceptions\MissingConstructorArgumentException($class, $name);
                    }
                } else {
                    $value = $arguments[$name];
                    // Remove the argument which was mapped to the constructor.
                    // All remaining arguments will be mapped to public properties.
                    unset($arguments[$name]);
                    if ($reflectionParameter->hasType()) {
                        $reflectionType = $reflectionParameter->getType();
                        if ($reflectionType instanceof ReflectionNamedType) {
                            $variableTypeName = $reflectionType->getName();
                        } else {
                            // @codeCoverageIgnoreStart
                            /** @noinspection PhpDeprecationInspection */
                            $variableTypeName = $reflectionType->__toString();
                            // @codeCoverageIgnoreEnd
                        }
                        if (in_array($variableTypeName, ['int', 'string', 'float', 'array', 'bool'])) {
                            settype($value, $variableTypeName);
                        }
                    }
                    $constructorArgs[$position] = $value;
                }
            }
        }

        foreach ($arguments as $name => $value) {
            if (!$reflectionClass->hasProperty($name)) {
                throw new Exceptions\MissingPropertyOrConstructorArgumentException($class, $name);
            }
            if (!$reflectionClass->getProperty($name)->isPublic()) {
                throw new Exceptions\PropertyNotPublicException($class, $name);
            }
        }

        $object = new $class(...$constructorArgs);

        foreach ($arguments as $name => $value) {
            $object->{$name} = $value;
        }

        return $object;
    }
}

if (!function_exists('\CoStack\Lib\filter')) {
    define(__NAMESPACE__ . '\\FILTER_INVERT', 1 << 0);
    define(__NAMESPACE__ . '\\FILTER_MATCH_LOOSE', 1 << 1);

    /**
     * For use with array_filter(). Creates a filter closure for you that matches the given $specimen.
     * The filter closure passed to array_filter will remove all elements, which do NOT match the $specimen.
     * You can invert the function to remove all entries which DO match your given $specimen by
     * passing the FILTER_INVERT flag.
     * The FILTER_MATCH_LOOSE flag can be added to use non-strict matching.
     *
     * @param int|float|string|bool $specimen The value to match against
     * @param int $flags FILTER_* constants from the \CoStack\Lib\ namespace
     * @return Closure
     * @throws Exception
     */
    function filter(int|float|string|bool $specimen, int $flags = 0): Closure
    {
        /** @var '=='|'==='|'!='|'!==' $comparison */
        $comparison = (($flags & FILTER_INVERT) ? '!' : '=') . '=' . (($flags & FILTER_MATCH_LOOSE) ? '' : '=');

        switch ($comparison) {
            case '==':
                return static function (mixed $probe) use ($specimen): bool {
                    return $probe == $specimen;
                };
            case '===':
                return static function (mixed $probe) use ($specimen): bool {
                    return $probe === $specimen;
                };
            case '!=':
                return static function (mixed $probe) use ($specimen): bool {
                    return $probe != $specimen;
                };
            case '!==':
                return static function (mixed $probe) use ($specimen): bool {
                    return $probe !== $specimen;
                };
        }
    }
}
