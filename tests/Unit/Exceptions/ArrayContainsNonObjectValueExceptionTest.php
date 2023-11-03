<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\ArrayContainsNonObjectValueException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\ArrayContainsNonObjectValueException
 */
class ArrayContainsNonObjectValueExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new ArrayContainsNonObjectValueException('foo', ['bar']);

        self::assertSame(1_599_055_645, $exception->getCode());
    }
}
