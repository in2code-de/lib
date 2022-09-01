<?php

declare(strict_types=1);

namespace CoStack\Lib\Utility;

use CoStack\Lib\Exceptions;
use ReflectionException;

use function CoStack\Lib\factory;

/**
 * @codeCoverageIgnore
 */
class ObjectUtility
{
    /**
     * @template T of object
     * @psalm-param class-string<T> $class
     * @param string $class
     * @param mixed[] $arguments
     * @return T of object
     *
     * @throws Exceptions\UnknownParameterTypeException
     * @throws Exceptions\ImpreciseParameterTypeException
     * @throws Exceptions\MissingConstructorArgumentException
     * @throws Exceptions\MissingPropertyOrConstructorArgumentException
     * @throws Exceptions\PropertyNotPublicException
     * @throws ReflectionException
     */
    public static function factory(string $class, array $arguments = [])
    {
        return factory($class, $arguments);
    }
}
