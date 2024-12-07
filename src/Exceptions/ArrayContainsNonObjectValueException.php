<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use Throwable;

use function gettype;
use function sprintf;

class ArrayContainsNonObjectValueException extends LibException
{
    private const MESSAGE = 'The given array must only contain objects, but the first element is a "%s"';
    final public const CODE = 1_599_055_645;

    /**
     * @param array<mixed> $array
     */
    public function __construct(public readonly mixed $value, public readonly array $array, ?Throwable $previous = null)
    {
        parent::__construct(sprintf(self::MESSAGE, gettype($value)), self::CODE, $previous);
    }
}
