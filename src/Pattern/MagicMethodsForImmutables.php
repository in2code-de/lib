<?php

declare(strict_types=1);

namespace CoStack\Lib\Pattern;

use CoStack\Lib\Exceptions\ArgumentCountErrorException;
use CoStack\Lib\Exceptions\BadMethodCallException;

use function substr;

trait MagicMethodsForImmutables
{
    /**
     * @param string $method
     * @param mixed[] $arguments
     * @return mixed
     * @throws ArgumentCountErrorException
     * @throws BadMethodCallException
     * @SuppressWarnings(PHPMD.CyclomaticComplexity) There is no perfect way to do this better
     */
    public function __call(string $method, array $arguments)
    {
        if ('is' === substr($method, 0, 2)) {
            $property = lcfirst(substr($method, 2));
            if (property_exists($this, $property)) {
                return (bool)$this->{$property};
            }
        }
        $method3 = substr($method, 0, 3);
        if ('get' === $method3 || 'has' === $method3) {
            $property = lcfirst(substr($method, 3));
            if (property_exists($this, $property)) {
                $value = $this->{$property};
                if ('has' === $method3) {
                    $value = null !== $value;
                }
                return $value;
            }
        }
        if ('without' === substr($method, 0, 7)) {
            $property = lcfirst(substr($method, 7));
            if (property_exists($this, $property)) {
                $clone = clone $this;
                $clone->$property = null;
                return $clone;
            }
        }
        if ('with' === substr($method, 0, 4)) {
            $property = lcfirst(substr($method, 4));
            if (property_exists($this, $property)) {
                if (!array_key_exists(0, $arguments)) {
                    throw new ArgumentCountErrorException(static::class, $method);
                }
                $clone = clone $this;
                $clone->$property = $arguments[0];
                return $clone;
            }
        }
        throw new BadMethodCallException(static::class, $method);
    }
}
