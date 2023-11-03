<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use JetBrains\PhpStorm\Pure;
use Throwable;

use function get_class;
use function gettype;
use function is_object;
use function sprintf;

class PropertyMustBePropertyNameOrCallable extends LibException
{
    private const MESSAGE = 'The property argument must be a property name or closure but is of type "%s" instead';
    public const CODE = 1_599_057_272;

    /**
     * @param mixed $value
     * @param object[] $array
     * @param Throwable|null $previous
     */
    #[Pure]
    public function __construct(private mixed $value, private array $array, Throwable $previous = null)
    {
        parent::__construct(
            sprintf(self::MESSAGE, get_debug_type($value)),
            self::CODE,
            $previous,
        );
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    /** @return object[] $array */
    public function getArray(): array
    {
        return $this->array;
    }
}
