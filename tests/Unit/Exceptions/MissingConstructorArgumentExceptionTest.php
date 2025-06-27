<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\MissingConstructorArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(MissingConstructorArgumentException::class)]
class MissingConstructorArgumentExceptionTest extends TestCase
{
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new MissingConstructorArgumentException('foo', 'bar');

        self::assertSame(1_599_662_098, $exception->getCode());
    }
}
