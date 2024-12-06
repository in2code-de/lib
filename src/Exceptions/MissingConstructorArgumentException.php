<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use JetBrains\PhpStorm\Pure;
use Throwable;

use function sprintf;

class MissingConstructorArgumentException extends LibException
{
    private const string MESSAGE = 'Missing constructor argument "%s" for class "%s".';
    final public const int CODE = 1_599_662_098;

    #[Pure]
    public function __construct(
        public readonly string $class,
        public readonly string $argumentName,
        Throwable $previous = null
    ) {
        parent::__construct(sprintf(self::MESSAGE, $argumentName, $class), self::CODE, $previous);
    }
}
