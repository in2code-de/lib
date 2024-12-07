<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use JetBrains\PhpStorm\Pure;
use Throwable;

use function sprintf;

class PropertyNotPublicException extends LibException
{
    private const MESSAGE = 'The property "%s" of class "%s" is not public.';
    final public const CODE = 1_624_002_587;

    #[Pure]
    public function __construct(
        public readonly string $class,
        public readonly string $property,
        ?Throwable $previous = null
    ) {
        parent::__construct(sprintf(self::MESSAGE, $property, $class), self::CODE, $previous);
    }
}
