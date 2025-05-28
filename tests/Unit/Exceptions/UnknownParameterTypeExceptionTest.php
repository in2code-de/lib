<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\UnknownParameterTypeException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(UnknownParameterTypeException::class)]
class UnknownParameterTypeExceptionTest extends TestCase
{
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new UnknownParameterTypeException('foo', 'bar');

        self::assertSame(1_662_032_156, $exception->getCode());
    }
}
