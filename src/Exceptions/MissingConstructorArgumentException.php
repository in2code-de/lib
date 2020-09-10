<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use Throwable;

class MissingConstructorArgumentException extends LibException
{
    private const MESSAGE = 'Missing constructor argument "%s" for class "%s".';
    public const CODE = 1599662098;

    private string $class;

    private string $argumentName;

    public function __construct(string $class, string $argumentName, Throwable $previous = null)
    {
        $this->class = $class;
        $this->argumentName = $argumentName;
        parent::__construct(sprintf(self::MESSAGE, $class, $argumentName), self::CODE, $previous);
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
