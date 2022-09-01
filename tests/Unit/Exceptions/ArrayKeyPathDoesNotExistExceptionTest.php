<?php

/** @noinspection NonSecureUniqidUsageInspection */

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\ArrayKeyPathDoesNotExistException;
use PHPUnit\Framework\TestCase;

use function uniqid;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\ArrayKeyPathDoesNotExistException
 */
class ArrayKeyPathDoesNotExistExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getPath
     * @covers ::getKey
     * @covers ::getArray
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $canaryPath = uniqid();
        $canaryKey = uniqid();
        $canaryArray = [uniqid()];

        $exception = new ArrayKeyPathDoesNotExistException($canaryPath, $canaryKey, $canaryArray);

        self::assertSame($canaryPath, $exception->getPath());
        self::assertSame($canaryKey, $exception->getKey());
        self::assertSame($canaryArray, $exception->getArray());
        self::assertSame(1598890975, $exception->getCode());
    }
}
