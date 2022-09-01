<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use JetBrains\PhpStorm\Pure;
use ReflectionType;
use Throwable;

use function sprintf;

class ImpreciseParameterTypeException extends LibException
{
    private const MESSAGE = 'Can not precisely determine the type of the parameter "%s" of the constructor of class "%s" because it has multiple types.';
    public const CODE = 1662028115;

    #[Pure]
    public function __construct(
        private string $parameter,
        private string $class,
        private ReflectionType $reflectionType,
        ?Throwable $previous = null
    ) {
        parent::__construct(sprintf(self::MESSAGE, $parameter, $class), self::CODE, $previous);
    }

    public function getParameter(): string
    {
        return $this->parameter;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getReflectionType(): ReflectionType
    {
        return $this->reflectionType;
    }
}
