<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use JetBrains\PhpStorm\Pure;
use Throwable;

use function sprintf;

class UnknownParameterTypeException extends LibException
{
    private const MESSAGE = 'The parameter "%s" of the constructor of class "%s" has no type.';
    final public const CODE = 1_662_032_156;

    #[Pure]
    public function __construct(
        public readonly string $parameter,
        public readonly string $class,
        ?Throwable $previous = null,
    ) {
        parent::__construct(sprintf(self::MESSAGE, $parameter, $class), self::CODE, $previous);
    }
}
