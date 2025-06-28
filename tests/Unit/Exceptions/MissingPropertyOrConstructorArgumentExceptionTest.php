<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\MissingPropertyOrConstructorArgumentException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings("PHPMD.LongClassName")
 */
#[CoversClass(MissingPropertyOrConstructorArgumentException::class)]
class MissingPropertyOrConstructorArgumentExceptionTest extends TestCase
{
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new MissingPropertyOrConstructorArgumentException('foo', 'bar');

        self::assertSame(1_624_002_516, $exception->getCode());
    }
}
