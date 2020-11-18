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

    private mixed $value;

    /** @var object[] */
    private array $array;

    /**
     * @param mixed $value
     * @param object[] $array
     * @param Throwable|null $previous
     */
    public function __construct(mixed $value, array $array, Throwable $previous = null)
    {
        $this->value = $value;
        $this->array = $array;

        parent::__construct(
            sprintf(self::MESSAGE, is_object($value) ? get_class($value) : gettype($value)),
            self::CODE,
            $previous
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
