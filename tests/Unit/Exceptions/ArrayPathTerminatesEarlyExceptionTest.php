<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\ArrayPathTerminatesEarlyException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ArrayPathTerminatesEarlyException::class)]
class ArrayPathTerminatesEarlyExceptionTest extends TestCase
{
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new ArrayPathTerminatesEarlyException('foo', 'bar', 'baz', ['beng']);

        self::assertSame(1_598_892_530, $exception->getCode());
    }
}
