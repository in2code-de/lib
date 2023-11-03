<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\ArrayPathTerminatesEarlyException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\ArrayPathTerminatesEarlyException
 */
class ArrayPathTerminatesEarlyExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new ArrayPathTerminatesEarlyException('foo', 'bar', 'baz', ['beng']);

        self::assertSame(1_598_892_530, $exception->getCode());
    }
}
