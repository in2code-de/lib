<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\ArrayPathTerminatesEarlyException;
use PHPUnit\Framework\TestCase;

use function uniqid;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\ArrayPathTerminatesEarlyException
 */
class ArrayPathTerminatesEarlyExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getPath
     * @covers ::getKey
     * @covers ::getValue
     * @covers ::getArray
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $canaryPath = uniqid();
        $canaryKey = uniqid();
        $canaryValue = uniqid();
        $canaryArray = [uniqid()];

        $exception = new ArrayPathTerminatesEarlyException($canaryPath, $canaryKey, $canaryValue, $canaryArray);

        self::assertSame($canaryPath, $exception->getPath());
        self::assertSame($canaryKey, $exception->getKey());
        self::assertSame($canaryValue, $exception->getValue());
        self::assertSame($canaryArray, $exception->getArray());
        self::assertSame(1598892530, $exception->getCode());
    }
}
