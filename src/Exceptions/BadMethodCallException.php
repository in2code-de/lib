<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use JetBrains\PhpStorm\Pure;
use Throwable;

use function sprintf;

class BadMethodCallException extends LibException
{
    private const MESSAGE = 'Call to undefined method "%s" on class "%s"';
    public const CODE = 1602239449;

    #[Pure]
    public function __construct(private string $class, private string $method, Throwable $previous = null)
    {
        parent::__construct(sprintf(self::MESSAGE, $method, $class), self::CODE, $previous);
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getMethod(): string
    {
        return $this->method;
    }
}
