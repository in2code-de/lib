<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\MissingConstructorArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\MissingConstructorArgumentException
 */
class MissingConstructorArgumentExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new MissingConstructorArgumentException('foo', 'bar');

        self::assertSame(1599662098, $exception->getCode());
    }
}
