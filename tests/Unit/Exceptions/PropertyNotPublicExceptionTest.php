<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\MissingPropertyOrConstructorArgumentException;
use CoStack\Lib\Exceptions\PropertyNotPublicException;
use PHPUnit\Framework\TestCase;

use function uniqid;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\PropertyNotPublicException
 */
class PropertyNotPublicExceptionTest extends TestCase
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

        $exception = new PropertyNotPublicException($canaryClass, $canaryPropertyName);

        self::assertSame($canaryClass, $exception->getClass());
        self::assertSame($canaryPropertyName, $exception->getProperty());
        self::assertSame(1624002587, $exception->getCode());
    }
}
