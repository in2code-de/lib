<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use Throwable;

use function get_debug_type;
use function sprintf;

class PropertyMustBePropertyNameOrCallable extends LibException
{
    private const string MESSAGE = 'The property argument must be a property name or closure but is of type "%s" instead';
    final public const int CODE = 1_599_057_272;

    /**
     * @param array<object> $array
     */
    public function __construct(public readonly mixed $value, public readonly array $array, Throwable $previous = null)
    {
        parent::__construct(
            sprintf(self::MESSAGE, get_debug_type($value)),
            self::CODE,
            $previous,
        );
    }
}
