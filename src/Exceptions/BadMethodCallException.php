<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use Throwable;

class BadMethodCallException extends LibException
{
    private const MESSAGE = 'Call to undefined method "%s" on class "%s"';
    public const CODE = 1602239449;

    /** @var string */
    private $class;

    /** @var string */
    private $method;

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
