<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\BadMethodCallException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\BadMethodCallException
 */
class BadMethodCallExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new BadMethodCallException('foo', 'bar');

        self::assertSame(1_602_239_449, $exception->getCode());
    }
}
