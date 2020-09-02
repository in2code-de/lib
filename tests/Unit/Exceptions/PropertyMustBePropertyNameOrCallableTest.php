<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\PropertyMustBePropertyNameOrCallable;
use PHPUnit\Framework\TestCase;

use function uniqid;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\PropertyMustBePropertyNameOrCallable
 */
class PropertyMustBePropertyNameOrCallableTest extends TestCase
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

        $exception = new PropertyMustBePropertyNameOrCallable($canaryValue, $canaryArray);

        self::assertSame($canaryValue, $exception->getValue());
        self::assertSame($canaryArray, $exception->getArray());
    }
}
