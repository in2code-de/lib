<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use JetBrains\PhpStorm\Pure;
use ReflectionType;
use Throwable;

use function sprintf;

class ImpreciseParameterTypeException extends LibException
{
    private const string MESSAGE = 'Can not precisely determine the type of the parameter "%s" of the constructor of class "%s" because it has multiple types.';
    final public const int CODE = 1_662_028_115;

    #[Pure]
    public function __construct(
        public readonly string $parameter,
        public readonly string $class,
        public readonly ReflectionType $reflectionType,
        ?Throwable $previous = null,
    ) {
        parent::__construct(sprintf(self::MESSAGE, $parameter, $class), self::CODE, $previous);
    }
}
