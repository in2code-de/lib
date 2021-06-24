<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\ArrayContainsNonObjectValueException;
use PHPUnit\Framework\TestCase;

use function uniqid;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\ArrayContainsNonObjectValueException
 */
class ArrayContainsNonObjectValueExceptionTest extends TestCase
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

        $exception = new ArrayContainsNonObjectValueException($canaryValue, $canaryArray);

        self::assertSame($canaryValue, $exception->getValue());
        self::assertSame($canaryArray, $exception->getArray());
        self::assertSame(1599055645, $exception->getCode());
    }
}
