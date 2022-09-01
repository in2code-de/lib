<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use Throwable;

use function sprintf;

class PropertyNotPublicException extends LibException
{
    private const MESSAGE = 'The property "%s" of class "%s" is not public.';
    public const CODE = 1624002587;
    private string $class;
    private string $property;

    public function __construct(string $class, string $property, Throwable $previous = null)
    {
        $this->class = $class;
        $this->property = $property;
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
