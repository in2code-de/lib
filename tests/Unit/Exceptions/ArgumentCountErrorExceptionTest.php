<?php

/** @noinspection NonSecureUniqidUsageInspection */

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\ArgumentCountErrorException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\ArgumentCountErrorException
 */
class ArgumentCountErrorExceptionTest extends TestCase
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

        $exception = new ArgumentCountErrorException($canaryClass, $canaryMethod);

        self::assertSame($canaryClass, $exception->getClass());
        self::assertSame($canaryMethod, $exception->getMethod());
        self::assertSame(1602239549, $exception->getCode());
    }
}
