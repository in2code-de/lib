<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use Throwable;

use function sprintf;

class PropertyNotPublicException extends LibException
{
    private const MESSAGE = 'The property "%s" of class "%s" is not public.';
    public const CODE = 1624002587;

    public function __construct(private string $class, private string $property, Throwable $previous = null)
    {
        parent::__construct(sprintf(self::MESSAGE, $property, $class), self::CODE, $previous);
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
