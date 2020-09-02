<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\ObjectArrayContainsNonObjectValueException;
use PHPUnit\Framework\TestCase;

use function uniqid;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\ObjectArrayContainsNonObjectValueException
 */
class ObjectArrayContainsNonObjectValueExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getValue
     * @covers ::getArray
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $canaryValue = uniqid();
        $canaryArray = [uniqid()];

        $exception = new ObjectArrayContainsNonObjectValueException($canaryValue, $canaryArray);

        self::assertSame($canaryValue, $exception->getValue());
        self::assertSame($canaryArray, $exception->getArray());
    }
}
