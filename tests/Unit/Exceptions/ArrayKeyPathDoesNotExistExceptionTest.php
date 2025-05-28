<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\ArrayKeyPathDoesNotExistException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ArrayKeyPathDoesNotExistException::class)]
class ArrayKeyPathDoesNotExistExceptionTest extends TestCase
{
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new ArrayKeyPathDoesNotExistException('foo', 'bar', ['baz']);

        self::assertSame(1_598_890_975, $exception->getCode());
    }
}
