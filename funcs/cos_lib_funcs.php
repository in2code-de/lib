<?php

declare(strict_types=1);

namespace CoStack\Lib;

use ArrayAccess;
use Closure;
use CoStack\Lib\Utility\StringPool;
use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\Pure;
use ReflectionClass;
use ReflectionException;
use ReflectionNamedType;
use ReflectionProperty;
use ReflectionUnionType;

use function array_column;
use function array_combine;
use function array_filter;
use function array_flip;
use function array_key_exists;
use function array_keys;
use function array_map;
use function array_merge;
use function array_pop;
use function array_values;
use function count;
use function define;
use function dirname;
use function explode;
use function function_exists;
use function gettype;
use function implode;
use function in_array;
use function is_array;
use function is_callable;
use function is_dir;
use function is_object;
use function is_string;
use function mkdir;
use function rawurldecode;
use function reset;
use function settype;
use function str_contains;
use function str_replace;
use function strpos;
use function substr;
use function trim;

use const DIRECTORY_SEPARATOR;

if (!function_exists('\CoStack\Lib\array_filter_recursive')) {
    /**
     * Filters an array the same way array_filter would, but recursively, until $limit is hit.
     *
     * @param array<array-key, int|string|array> $array
     * @param callable|null $callback
     * @return array<array-key, (int|string|array)>
     */
    function array_filter_recursive(array $array, int $limit, ?callable $callback = null, int $flags = 0): array
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
     * @param array|ArrayAccess $array
     * @param string $path
     * @return mixed
     * @throws Exceptions\ArrayKeyPathDoesNotExistException
     * @throws Exceptions\ArrayPathTerminatesEarlyException
     */
    function array_value(array|ArrayAccess $array, string $path): mixed
    {
        // Trim all chars and dots
        $path = trim($path, " \t\n\r\0\x0B.");
        if (empty($path)) {
            return $array;
        }
        $return = $array;
        // Iteration is 3 times faster than recursion
        foreach (explode('.', $path) as $key) {
            if (is_array($return)) {
                // isset() first is no longer faster with PHP >= 7.4
                if (!array_key_exists($key, $return)) {
                    throw new Exceptions\ArrayKeyPathDoesNotExistException($path, $key, $array);
                }
            } elseif ($return instanceof ArrayAccess) {
                if (!$return->offsetExists($key)) {
                    throw new Exceptions\ArrayKeyPathDoesNotExistException($path, $key, $array);
                }
            } else {
                throw new Exceptions\ArrayPathTerminatesEarlyException($path, $key, $return, $array);
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
     * @return array
     * @throws Exceptions\ArrayContainsNonObjectValueException
     * @throws Exceptions\PropertyMustBePropertyNameOrCallable
     * @throws ReflectionException
     */
    function array_property(
        array $array,
        null|string|callable $property,
        null|string|callable $indexKey = null,
    ): array {
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

if (!function_exists('\CoStack\Lib\array_unique_keys')) {
    /**
     * Return all keys from all arrays in a list.
     * A list consist of consecutive key numbers from 0 to count($array)-1
     *
     * @param array ...$arrays
     * @return array<int, int|string>
     *
     * @psalm-suppress NamedArgumentNotAllowed
     */
    function array_unique_keys(array ...$arrays): array
    {
        // array_keys(array_flip(...)) is a bit (~2.5%) faster than array_values(array_unique(...))
        return array_keys(array_flip(array_merge(...array_map('array_keys', $arrays))));
    }
}

if (!function_exists('\CoStack\Lib\concat_paths')) {
    /**
     * Concatenate filesystem paths
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
     */
    function mkdir_deep(string $path, ?int $mode = null): bool
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
     * @template T of object
     * @psalm-param class-string<T> $class
     * @return T of object
     *
     * @throws Exceptions\ImpreciseParameterTypeException
     * @throws Exceptions\MissingConstructorArgumentException
     * @throws Exceptions\MissingPropertyOrConstructorArgumentException
     * @throws Exceptions\PropertyNotPublicException
     * @throws ReflectionException
     */
    function factory(string $class, array $arguments = [])
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
                        $currentType = str_replace(
                            ['integer', 'boolean', 'double', 'NULL'],
                            ['int', 'bool', 'float', 'null'],
                            gettype($value),
                        );
                        $expectedType = null;
                        $reflectionType = $reflectionParameter->getType();
                        if ($reflectionType instanceof ReflectionUnionType) {
                            foreach ($reflectionType->getTypes() as $type) {
                                if (
                                    $type instanceof ReflectionNamedType
                                    && $type->getName() === $currentType
                                ) {
                                    $expectedType = $currentType;
                                    break;
                                }
                            }
                            if (null === $expectedType) {
                                throw new Exceptions\ImpreciseParameterTypeException($name, $class, $reflectionType);
                            }
                        } elseif ($reflectionType instanceof ReflectionNamedType) {
                            $expectedType = $reflectionType->getName();
                        }
                        if (
                            $currentType !== $expectedType
                            && in_array($expectedType, ['int', 'string', 'float', 'array', 'bool'])
                        ) {
                            /** @psalm-suppress PossiblyNullArgument */
                            settype($value, $expectedType);
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
    define(__NAMESPACE__ . '\FILTER_INVERT', 1 << 0);
    define(__NAMESPACE__ . '\FILTER_MATCH_LOOSE', 1 << 1);

    /**
     * For use with array_filter(). Creates a filter closure for you that matches the given $specimen.
     * The filter closure passed to array_filter will remove all elements, which do NOT match the $specimen.
     * You can invert the function to remove all entries which DO match your given $specimen by
     * passing the FILTER_INVERT flag.
     * The FILTER_MATCH_LOOSE flag can be added to use non-strict matching.
     *
     * @param int|float|string|bool $specimen The value to match against
     * @param int $flags FILTER_* constants from the \CoStack\Lib\ namespace
     * @noinspection TypeUnsafeComparisonInspection
     * @noinspection PhpUnused
     */
    #[Pure]
    #[ExpectedValues(flags: [0, FILTER_INVERT, FILTER_MATCH_LOOSE])]
    function filter(int|float|string|bool $specimen, int $flags = 0): Closure
    {
        /** @var '=='|'==='|'!='|'!==' $comparison */
        $comparison = (($flags & FILTER_INVERT) ? '!' : '=') . '=' . (($flags & FILTER_MATCH_LOOSE) ? '' : '=');

        return match ($comparison) {
            '==' => static fn(mixed $probe): bool => $probe == $specimen,
            '===' => static fn(mixed $probe): bool => $probe === $specimen,
            '!=' => static fn(mixed $probe): bool => $probe != $specimen,
            '!==' => static fn(mixed $probe): bool => $probe !== $specimen,
        };
    }
}

if (!function_exists('\CoStack\Lib\cgi_parse_str')) {
    /**
     * parse_str is affected by max_input_vars and therefore not pure.
     * Also, it is not CGI compliant, as it does not parse multiple values
     * into an array, if the keys aren't suffixed with array brackets '[]'.
     *
     * @param string $string The string to parse, mostly the path component of a URI.
     * @return array<string, string|array<string, string>> Array of key-value pairs, where values can be an array, too.
     */
    #[Pure]
    function cgi_parse_str(string $string): array
    {
        $result = [];

        $values = explode('&', $string);

        foreach ($values as $value) {
            $parts = explode('=', $value, 2);
            [$name, $value] = match (count($parts)) {
                1 => [$parts[0], ''],
                2 => [$parts[0], rawurldecode($parts[1])],
            };

            if ('' !== $name) {
                if (isset($result[$name])) {
                    if (is_array($result[$name])) {
                        $result[$name][] = $value;
                    } else {
                        $result[$name] = [$result[$name], $value];
                    }
                } else {
                    $result[$name] = $value;
                }
            }
        }

        return $result;
    }
}

if (!function_exists('\CoStack\Lib\pool')) {
    /**
     * Pool a string.
     * This will put a string into an array and return the string from that array.
     * The result is a copy-on-write reference to the string.
     * The size required by the variable holding the string is reduced to the site of PHP's zval.
     * (16 bytes, @see https://github.com/phpinternalsbook/PHP-Internals-Book/blob/master/Book/php7/zvals/basic_structure.rst?plain=1#L183)
     * This is especially useful if you have data where strings occur multiple times.
     *
     * This function does not have a garbage collection!
     * If you pool a string, it will be stored in memory until your script ends.
     *
     * Putting a string in the pool is not always the best choice, but you
     * will use an additional 216 bytes for each string in the worst case.
     *
     * There is no simple match function to determine if using the pool actually saves memory, because it depends on the
     * size of zval on your system, the length and the amount of times you are using the string.
     *
     * As a rule of thumb, you should
     * A) Not pool a string if
     * A.1) the string length is 0
     * A.2) you only need the string temporarily
     * A.3) you use it 5 times and the length is between 10 and 15
     * A.4) you try to pool only different strings
     * B) Always pool a string if
     * B.1) you use it more than 11 times
     * B.2) string length is >= 20
     * B.3) for string length < 20: it's used more times than string length / 48
     * B.4) you don't care about the tradeoff
     *
     * These rules will get about 85% for lengths 0-100 and times 0-100 right, but only for high numbers.
     * As there is no easy solution, you should decide when to pool a
     * string by yourself, hence this logic is not implemented here.
     *
     * @param string $string The string you want to put into the pool.
     * @return string The same string you put into the function, but it will use less memory.
     */
    function pool(string $string): string
    {
        // Use a class because the initialization of a static class member takes less than a static function variable.
        // Also, it allows flushing the pool.
        return StringPool::get($string);
    }
}

if (!function_exists('enumerate')) {
    /**
     * Like implode, but uses "," as glue and adds the last element with a different separator.
     * The use case is imploding strings for natural (human) language.
     *
     * Oxford-Comma:
     *  The Oxford comma (also known as the serial comma) is a comma that is placed
     *  before the word "and" or "or" in a list—that is, before the last element of a list.
     *
     *  With Oxford-Comma:
     *      I love my parents, Lady Gaga, and Superman.
     *
     *  Without Oxford-Comma:
     *      I love my parents, Lady Gaga and Superman.
     *
     *  The difference is subtle but important:
     *      Without the Oxford comma, the second sentence could be understood
     *      as if Lady Gaga and Superman were the parents of the person speaking.
     *      With the Oxford comma, the list is unambiguous.
     *
     * @param string $glue The glue for the last element. Most of the time "and" in the target language.
     * @param array<string> $strings Array of strings that will be imploded
     * @param bool $oxfordComma Add a comma before the last element in lists of elements >= 3
     * @return string The concatenated parts of $strings
     * @SuppressWarnings("PHPMD.BooleanArgumentFlag")
     */
    function enumerate(string $glue, array $strings, bool $oxfordComma = false): string
    {
        $input = array_values($strings);

        return match (count($input)) {
            0 => '',
            1 => $input[0],
            2 => $input[0] . $glue . $input[1],
            default => (static function () use ($input, $glue, $oxfordComma): string {
                $end = '';
                if ($oxfordComma) {
                    $end .= ',';
                }
                $end .= $glue;
                $end .= array_pop($input);
                return implode(', ', $input) . $end;
            })()
        };
    }
}
