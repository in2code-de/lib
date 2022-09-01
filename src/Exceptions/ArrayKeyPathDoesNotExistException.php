<?php

declare(strict_types=1);

namespace CoStack\Lib\Exceptions;

use Throwable;

use function sprintf;

class ArrayKeyPathDoesNotExistException extends LibException
{
    private const MESSAGE = 'The array path "%s" does not exist in the given array, because the key "%s" can not be found';
    public const CODE = 1598890975;
    private string $path;
    private string $key;
    /** @var mixed[] */
    private array $array;

    /**
     * @param string $path
     * @param string $key
     * @param mixed[] $array
     * @param Throwable|null $previous
     */
    public function __construct(string $path, string $key, array $array, Throwable $previous = null)
    {
        $this->path = $path;
        $this->key = $key;
        $this->array = $array;

        parent::__construct(sprintf(self::MESSAGE, $path, $key), self::CODE, $previous);
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    /** @return mixed[] $array */
    public function getArray(): array
    {
        return $this->array;
    }
}
