<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use Throwable;

use function gettype;
use function sprintf;

class ArrayPathTerminatesEarlyException extends LibException
{
    private const MESSAGE = 'The array path "%s" is terminated early, because the value before key "%s" is a "%s" instead of an array';
    final public const CODE = 1_598_892_530;

    /**
     * @param array<mixed> $array
     */
    public function __construct(
        public readonly string $path,
        public readonly string $key,
        public readonly mixed $value,
        public readonly array $array,
        Throwable $previous = null,
    ) {
        parent::__construct(sprintf(self::MESSAGE, $path, $key, gettype($value)), self::CODE, $previous);
    }
}
