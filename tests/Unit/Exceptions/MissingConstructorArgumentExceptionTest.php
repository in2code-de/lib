<?php

/** @noinspection NonSecureUniqidUsageInspection */

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\MissingConstructorArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\MissingConstructorArgumentException
 */
class MissingConstructorArgumentExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getClass
     * @covers ::getArgumentName
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $canaryClass = uniqid();
        $canaryArgumentName = uniqid();

        $exception = new MissingConstructorArgumentException($canaryClass, $canaryArgumentName);

        self::assertSame($canaryClass, $exception->getClass());
        self::assertSame($canaryArgumentName, $exception->getArgumentName());
        self::assertSame(1_599_662_098, $exception->getCode());
    }
}
