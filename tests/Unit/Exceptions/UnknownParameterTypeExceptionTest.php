<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\UnknownParameterTypeException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\UnknownParameterTypeException
 */
class UnknownParameterTypeExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new UnknownParameterTypeException('foo', 'bar');

        self::assertSame(1_662_032_156, $exception->getCode());
    }
}
