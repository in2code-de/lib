<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\ImpreciseParameterTypeException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use ReflectionUnionType;

#[CoversClass(ImpreciseParameterTypeException::class)]
class ImpreciseParameterTypeExceptionTest extends TestCase
{
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new ImpreciseParameterTypeException('foo', 'bar', new ReflectionUnionType());

        self::assertSame(1_662_028_115, $exception->getCode());
    }
}
