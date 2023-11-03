<?php

/** @noinspection NonSecureUniqidUsageInspection */

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\PropertyMustBePropertyNameOrCallable;
use PHPUnit\Framework\TestCase;
use stdClass;

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
        $canaryArray = [new stdClass()];

        $exception = new PropertyMustBePropertyNameOrCallable($canaryValue, $canaryArray);

        self::assertSame($canaryValue, $exception->getValue());
        self::assertSame($canaryArray, $exception->getArray());
        self::assertSame(1_599_057_272, $exception->getCode());
    }
}
