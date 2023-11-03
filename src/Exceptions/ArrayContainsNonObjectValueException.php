<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use Throwable;

use function gettype;
use function sprintf;

class ArrayContainsNonObjectValueException extends LibException
{
    private const MESSAGE = 'The given array must only contain objects, but the first element is a "%s"';
    public const CODE = 1_599_055_645;
    /** @var mixed */
    private $value;
    /** @var mixed[] */
    private array $array;

    /**
     * @param mixed $value
     * @param mixed[] $array
     * @param Throwable|null $previous
     */
    public function __construct($value, array $array, Throwable $previous = null)
    {
        $this->value = $value;
        $this->array = $array;

        parent::__construct(sprintf(self::MESSAGE, gettype($value)), self::CODE, $previous);
    }

    /** @return mixed */
    public function getValue()
    {
        return $this->value;
    }

    /** @return mixed[] $array */
    public function getArray(): array
    {
        return $this->array;
    }
}
