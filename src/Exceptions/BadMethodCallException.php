<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use JetBrains\PhpStorm\Pure;
use Throwable;

use function sprintf;

class BadMethodCallException extends LibException
{
    private const string MESSAGE = 'Call to undefined method "%s" on class "%s"';
    final public const int CODE = 1_602_239_449;

    #[Pure]
    public function __construct(
        public readonly string $class,
        public readonly string $method,
        ?Throwable $previous = null,
    ) {
        parent::__construct(sprintf(self::MESSAGE, $method, $class), self::CODE, $previous);
    }
}
