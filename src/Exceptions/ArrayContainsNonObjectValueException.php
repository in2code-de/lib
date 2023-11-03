<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use JetBrains\PhpStorm\Pure;
use Throwable;

use function gettype;
use function sprintf;

class ArrayContainsNonObjectValueException extends LibException
{
    private const MESSAGE = 'The given array must only contain objects, but the first element is a "%s"';
    public const CODE = 1_599_055_645;

    /**
     * @param mixed $value
     * @param mixed[] $array
     * @param Throwable|null $previous
     */
    #[Pure]
    public function __construct(private mixed $value, private array $array, Throwable $previous = null)
    {
        parent::__construct(sprintf(self::MESSAGE, gettype($value)), self::CODE, $previous);
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    /** @return mixed[] $array */
    public function getArray(): array
    {
        return $this->array;
    }
}
