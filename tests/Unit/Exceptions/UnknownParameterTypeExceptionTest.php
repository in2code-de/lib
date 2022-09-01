<?php

/** @noinspection NonSecureUniqidUsageInspection */

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\UnknownParameterTypeException;
use PHPUnit\Framework\TestCase;

use function uniqid;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\UnknownParameterTypeException
 */
class UnknownParameterTypeExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getParameter
     * @covers ::getClass
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $parameterCanary = uniqid();
        $classCanary = uniqid();

        $exception = new UnknownParameterTypeException($parameterCanary, $classCanary);

        self::assertSame($parameterCanary, $exception->getParameter());
        self::assertSame($classCanary, $exception->getClass());
        self::assertSame(1662032156, $exception->getCode());
    }
}
