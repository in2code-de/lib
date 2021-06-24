<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\TypeErrorException;
use PHPUnit\Framework\TestCase;

use function uniqid;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\TypeErrorException
 */
class TypeErrorExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getArgumentName
     * @covers ::getActualType
     * @covers ::getExpectedType
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $canaryArgumentName = uniqid();
        $canaryActualType = uniqid();
        $canaryExpectedType = uniqid();

        $exception = new TypeErrorException($canaryArgumentName, $canaryActualType, $canaryExpectedType);

        self::assertSame($canaryArgumentName, $exception->getArgumentName());
        self::assertSame($canaryActualType, $exception->getActualType());
        self::assertSame($canaryExpectedType, $exception->getExpectedType());
        self::assertSame(1607526148, $exception->getCode());
    }
}
