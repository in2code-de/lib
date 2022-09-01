<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use Throwable;

use function sprintf;

class ArgumentCountErrorException extends LibException
{
    private const MESSAGE = 'Missing argument for method "%s" on class "%s"';
    public const CODE = 1602239549;
    private string $class;
    private string $method;

    public function __construct(string $class, string $method, Throwable $previous = null)
    {
        $this->class = $class;
        $this->method = $method;
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
