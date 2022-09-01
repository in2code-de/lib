<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\PropertyMustBePropertyNameOrCallable;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\PropertyMustBePropertyNameOrCallable
 */
class PropertyMustBePropertyNameOrCallableTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new PropertyMustBePropertyNameOrCallable('foo', [new stdClass()]);

        self::assertSame(
            'The property argument must be a property name or closure but is of type "string" instead',
            $exception->getMessage()
        );
        self::assertSame(1599057272, $exception->getCode());
    }
}
