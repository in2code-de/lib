<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use Throwable;

use function sprintf;

/**
 * @SuppressWarnings(PHPMD.LongClassName) Exception class names should be descriptive, shouldn't they?
 */
class MissingPropertyOrConstructorArgumentException extends LibException
{
    private const MESSAGE = 'The class "%s" does not define a property or constructor argument named "%s"';
    public const CODE = 1_624_002_516;
    private string $class;
    private string $property;

    public function __construct(string $class, string $property, Throwable $previous = null)
    {
        $this->class = $class;
        $this->property = $property;
        parent::__construct(sprintf(self::MESSAGE, $class, $property), self::CODE, $previous);
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getProperty(): string
    {
        return $this->property;
    }
}
