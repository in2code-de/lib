<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\MissingPropertyOrConstructorArgumentException;
use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.LongClassName)
 * @coversDefaultClass \CoStack\Lib\Exceptions\MissingPropertyOrConstructorArgumentException
 */
class MissingPropertyOrConstructorArgumentExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new MissingPropertyOrConstructorArgumentException('foo', 'bar');

        self::assertSame(1_624_002_516, $exception->getCode());
    }
}
