<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use Throwable;

use function get_class;
use function is_object;
use function sprintf;

class PropertyMustBePropertyNameOrCallable extends LibException
{
    private const MESSAGE = 'The property argument must be a property name or closure but is of type "%s" instead';
    public const CODE = 1599057272;

    /**
     * @param array<object> $array
     */
    public function __construct(public readonly mixed $value, public readonly array $array, Throwable $previous = null)
    {
        parent::__construct(
            sprintf(self::MESSAGE, is_object($value) ? get_class($value) : gettype($value)),
            self::CODE,
            $previous,
        );
    }
}
