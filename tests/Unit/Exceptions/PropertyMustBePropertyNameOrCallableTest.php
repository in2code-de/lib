<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\PropertyMustBePropertyNameOrCallable;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use stdClass;

#[CoversClass(PropertyMustBePropertyNameOrCallable::class)]
class PropertyMustBePropertyNameOrCallableTest extends TestCase
{
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new PropertyMustBePropertyNameOrCallable('foo', [new stdClass()]);

        self::assertSame(
            'The property argument must be a property name or closure but is of type "string" instead',
            $exception->getMessage(),
        );
        self::assertSame(1_599_057_272, $exception->getCode());
    }
}
