<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Exceptions;

use CoStack\Lib\Exceptions\ArgumentCountErrorException;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \CoStack\Lib\Exceptions\ArgumentCountErrorException
 */
class ArgumentCountErrorExceptionTest extends TestCase
{
    /**
     * @covers ::__construct
     */
    public function testExceptionContainsConstructorArguments(): void
    {
        $exception = new ArgumentCountErrorException('foo', 'bar');

        self::assertSame(1_602_239_549, $exception->getCode());
    }
}
