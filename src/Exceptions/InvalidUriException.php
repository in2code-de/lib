<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use JetBrains\PhpStorm\Pure;
use Throwable;

use function sprintf;

class InvalidUriException extends LibException
{
    private const MESSAGE = 'Given string "%s" is not a valid URI.';
    final public const CODE = 1_748_467_168;

    #[Pure]
    public function __construct(
        public readonly string $string,
        ?Throwable $previous = null,
    ) {
        parent::__construct(sprintf(self::MESSAGE, $string), self::CODE, $previous);
    }
}
