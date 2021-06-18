<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\MissingPropertyOrConstructorArgumentException;
use PHPUnit\Framework\TestCase;

use function uniqid;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\MissingPropertyOrConstructorArgumentException
 */
class MissingPropertyOrConstructorArgumentExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getClass
     * @covers ::getArgumentName
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $canaryClass = uniqid();
        $canaryPropertyName = uniqid();

        $exception = new MissingPropertyOrConstructorArgumentException($canaryClass, $canaryPropertyName);

        self::assertSame($canaryClass, $exception->getClass());
        self::assertSame($canaryPropertyName, $exception->getProperty());
    }
}
