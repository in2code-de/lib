<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\ArrayContainsNonObjectValueException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ArrayContainsNonObjectValueException::class)]
class ArrayContainsNonObjectValueExceptionTest extends TestCase
{
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new ArrayContainsNonObjectValueException('foo', ['bar']);

        self::assertSame(1_599_055_645, $exception->getCode());
    }
}
