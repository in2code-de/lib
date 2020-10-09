<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\BadMethodCallException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\BadMethodCallException
 */
class BadMethodCallExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getClass
     * @covers ::getMethod
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $canaryClass = uniqid();
        $canaryMethod = uniqid();

        $exception = new BadMethodCallException($canaryClass, $canaryMethod);

        self::assertSame($canaryClass, $exception->getClass());
        self::assertSame($canaryMethod, $exception->getMethod());
    }
}
