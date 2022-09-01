<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\ImpreciseParameterTypeException;
use PHPUnit\Framework\TestCase;
use ReflectionUnionType;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\ImpreciseParameterTypeException
 */
class ImpreciseParameterTypeExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new ImpreciseParameterTypeException('foo', 'bar', new ReflectionUnionType());

        self::assertSame(1662028115, $exception->getCode());
    }
}
