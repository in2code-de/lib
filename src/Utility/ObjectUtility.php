<?php

declare(strict_types=1);

namespace CoStack\Lib\Utility;

use CoStack\Lib\Exceptions\MissingConstructorArgumentException;
use ReflectionException;

use function CoStack\Lib\factory;

/**
 * @codeCoverageIgnore
 */
class ObjectUtility
{
    /**
     * @template T
     * @psalm-param class-string<T> $class
     * @param string $class
     * @param mixed[] $arguments
     * @psalm-return T
     * @return object
     *
     * @throws MissingConstructorArgumentException
     * @throws ReflectionException
     */
    public static function factory(string $class, array $arguments = []): object
    {
        return factory($class, $arguments);
    }
}
