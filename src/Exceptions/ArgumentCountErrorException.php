<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use JetBrains\PhpStorm\Pure;
use Throwable;

use function sprintf;

class ArgumentCountErrorException extends LibException
{
    private const MESSAGE = 'Missing argument for method "%s" on class "%s"';
    public const CODE = 1602239549;

    #[Pure]
    public function __construct(
        public readonly string $class,
        public readonly string $method,
        Throwable $previous = null
    ) {
        parent::__construct(sprintf(self::MESSAGE, $method, $class), self::CODE, $previous);
    }
}
