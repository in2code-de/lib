<?php

/** @noinspection NonSecureUniqidUsageInspection */

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\MissingPropertyOrConstructorArgumentException;
use PHPUnit\Framework\TestCase;

use function uniqid;

/**
 * @SuppressWarnings(PHPMD.LongClassName)
 * @coversDefaultClass \CoStack\Lib\Exceptions\MissingPropertyOrConstructorArgumentException
 */
class MissingPropertyOrConstructorArgumentExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getClass
     * @covers ::getProperty
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $canaryClass = uniqid();
        $canaryPropertyName = uniqid();

        $exception = new MissingPropertyOrConstructorArgumentException($canaryClass, $canaryPropertyName);

        self::assertSame($canaryClass, $exception->getClass());
        self::assertSame($canaryPropertyName, $exception->getProperty());
        self::assertSame(1624002516, $exception->getCode());
    }
}
