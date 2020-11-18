<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use Throwable;

class MissingConstructorArgumentException extends LibException
{
    private const MESSAGE = 'Missing constructor argument "%s" for class "%s".';
    public const CODE = 1599662098;

    public function __construct(private string $class, private string $argumentName, Throwable $previous = null)
    {
        parent::__construct(sprintf(self::MESSAGE, $argumentName, $class), self::CODE, $previous);
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getArgumentName(): string
    {
        return $this->argumentName;
    }
}
