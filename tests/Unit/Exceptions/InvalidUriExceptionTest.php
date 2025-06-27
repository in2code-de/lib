<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\InvalidUriException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(InvalidUriException::class)]
class InvalidUriExceptionTest extends TestCase
{
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new InvalidUriException('foo');

        self::assertSame(1_748_467_168, $exception->getCode());
    }
}
