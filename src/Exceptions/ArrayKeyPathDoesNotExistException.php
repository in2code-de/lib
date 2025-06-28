<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use ArrayAccess;
use JetBrains\PhpStorm\Pure;
use Throwable;

use function sprintf;

class ArrayKeyPathDoesNotExistException extends LibException
{
    private const MESSAGE = 'The array path "%s" does not exist in the given array, because the key "%s" can not be found';
    final public const CODE = 1_598_890_975;

    /**
     * @param array<mixed>|ArrayAccess<mixed, mixed> $array
     */
    #[Pure]
    public function __construct(
        public readonly string $path,
        public readonly string $key,
        public readonly array|ArrayAccess $array,
        ?Throwable $previous = null,
    ) {
        parent::__construct(sprintf(self::MESSAGE, $path, $key), self::CODE, $previous);
    }
}
