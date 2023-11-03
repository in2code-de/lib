<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\ArrayKeyPathDoesNotExistException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\ArrayKeyPathDoesNotExistException
 */
class ArrayKeyPathDoesNotExistExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new ArrayKeyPathDoesNotExistException('foo', 'bar', ['baz']);

        self::assertSame(1_598_890_975, $exception->getCode());
    }
}
