<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\PropertyNotPublicException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\PropertyNotPublicException
 */
class PropertyNotPublicExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new PropertyNotPublicException('foo', 'bar');

        self::assertSame(1624002587, $exception->getCode());
    }
}
