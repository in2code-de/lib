<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\PropertyNotPublicException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(PropertyNotPublicException::class)]
class PropertyNotPublicExceptionTest extends TestCase
{
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new PropertyNotPublicException('foo', 'bar');

        self::assertSame(1_624_002_587, $exception->getCode());
    }
}
