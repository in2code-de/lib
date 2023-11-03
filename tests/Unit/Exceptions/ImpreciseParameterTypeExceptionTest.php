<?php

/** @noinspection NonSecureUniqidUsageInspection */

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\ImpreciseParameterTypeException;
use PHPUnit\Framework\TestCase;
use ReflectionUnionType;

use function uniqid;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\ImpreciseParameterTypeException
 */
class ImpreciseParameterTypeExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getParameter
     * @covers ::getClass
     * @covers ::getReflectionType
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $parameterCanary = uniqid();
        $classCanary = uniqid();
        $reflectionTypeCanary = new ReflectionUnionType();

        $exception = new ImpreciseParameterTypeException($parameterCanary, $classCanary, $reflectionTypeCanary);

        self::assertSame($parameterCanary, $exception->getParameter());
        self::assertSame($classCanary, $exception->getClass());
        self::assertSame($reflectionTypeCanary, $exception->getReflectionType());
        self::assertSame(1_662_028_115, $exception->getCode());
    }
}
