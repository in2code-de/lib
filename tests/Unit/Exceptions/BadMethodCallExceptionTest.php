<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\BadMethodCallException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(BadMethodCallException::class)]
class BadMethodCallExceptionTest extends TestCase
{
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new BadMethodCallException('foo', 'bar');

        self::assertSame(1_602_239_449, $exception->getCode());
    }
}
