<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use JetBrains\PhpStorm\Pure;
use Throwable;

use function sprintf;

class MissingConstructorArgumentException extends LibException
{
    private const MESSAGE = 'Missing constructor argument "%s" for class "%s".';
    public const CODE = 1599662098;

    #[Pure]
    public function __construct(
        public readonly string $class,
        public readonly string $argumentName,
        Throwable $previous = null
    ) {
        parent::__construct(sprintf(self::MESSAGE, $argumentName, $class), self::CODE, $previous);
    }
}
