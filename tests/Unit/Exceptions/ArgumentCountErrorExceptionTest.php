<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\ArgumentCountErrorException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(ArgumentCountErrorException::class)]
class ArgumentCountErrorExceptionTest extends TestCase
{
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new ArgumentCountErrorException('foo', 'bar');

        self::assertSame(1_602_239_549, $exception->getCode());
    }
}
