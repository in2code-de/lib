<?php

declare(strict_types=1);

namespace CoStack\Lib\Pattern;

use CoStack\Lib\Exceptions\ArgumentCountErrorException;
use CoStack\Lib\Exceptions\BadMethodCallException;

trait MagicMethodsForImmutables
{
    /**
     * @param string $method
     * @param mixed[] $arguments
     * @return mixed|bool|static
     */
    public function __call(string $method, array $arguments)
    {
        $method3 = substr($method, 0, 3);
        if ('get' === $method3 || 'has' === $method3) {
            $property3 = lcfirst(substr($method, 3));
            if (property_exists($this, $property3)) {
                $value = $this->{$property3};
                if ('has' === $method3) {
                    $value = null !== $value;
                }
                return $value;
            }
            throw new BadMethodCallException(static::class, $method);
        }
        $method4 = substr($method, 0, 4);
        if ('with' === $method4) {
            $property4 = lcfirst(substr($method, 4));
            if (property_exists($this, $property4)) {
                if (!array_key_exists(0, $arguments)) {
                    throw new ArgumentCountErrorException(static::class, $method);
                }
                $clone = clone $this;
                $clone->$property4 = $arguments[0];
                return $clone;
            }
        }
        throw new BadMethodCallException(static::class, $method);
    }
}
