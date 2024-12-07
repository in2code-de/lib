<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use JetBrains\PhpStorm\Pure;
use Throwable;

use function sprintf;

/**
 * @SuppressWarnings("PHPMD.LongClassName") Exception class names should be descriptive, shouldn't they?
 */
class MissingPropertyOrConstructorArgumentException extends LibException
{
    private const string MESSAGE = 'The class "%s" does not define a property or constructor argument named "%s"';
    final public const int CODE = 1_624_002_516;

    #[Pure]
    public function __construct(
        public readonly string $class,
        public readonly string $property,
        ?Throwable $previous = null
    ) {
        parent::__construct(sprintf(self::MESSAGE, $class, $property), self::CODE, $previous);
    }
}
