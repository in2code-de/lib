<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use Throwable;

use function gettype;
use function sprintf;

class ArrayPathTerminatesEarlyException extends LibException
{
    private const MESSAGE = 'The array path "%s" is terminated early, because the value before key "%s" is a "%s" instead of an array';
    public const CODE = 1598892530;

    /**
     * @param string $path
     * @param string $key
     * @param mixed $value
     * @param mixed[] $array
     * @param Throwable|null $previous
     */
    // phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
    public function __construct(
        private string $path,
        private string $key,
        private mixed $value,
        private array $array,
        Throwable $previous = null,
    ) {
        // phpcs:enable Generic.WhiteSpace.ScopeIndent.IncorrectExact
        parent::__construct(
            sprintf(self::MESSAGE, $path, $key, gettype($value)),
            self::CODE,
            $previous,
        );
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    /** @return mixed */
    public function getValue()
    {
        return $this->value;
    }

    /** @return mixed[] $array */
    public function getArray(): array
    {
        return $this->array;
    }
}
