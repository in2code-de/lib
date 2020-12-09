<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use Throwable;

use function sprintf;

class TypeErrorException extends LibException
{
    private const MESSAGE = 'The argument "%s" must be of type "%s", but is of type "%s"';
    public const CODE = 1607526148;

    private string $argumentName;

    private string $actualType;

    private string $expectedType;

    public function __construct(
        string $argumentName,
        string $actualType,
        string $expectedType,
        Throwable $previous = null
    ) {
        $this->argumentName = $argumentName;
        $this->actualType = $actualType;
        $this->expectedType = $expectedType;
        parent::__construct(sprintf(self::MESSAGE, $argumentName, $actualType, $expectedType), self::CODE, $previous);
    }

    public function getArgumentName(): string
    {
        return $this->argumentName;
    }

    public function getActualType(): string
    {
        return $this->actualType;
    }

    public function getExpectedType(): string
    {
        return $this->expectedType;
    }
}
