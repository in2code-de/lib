<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use CoStack\Lib\Exceptions\ArrayKeyPathDoesNotExistException;
use CoStack\Lib\Exceptions\ArrayPathTerminatesEarlyException;
use PHPUnit\Framework\TestCase;
use stdClass;

use function array_value;

class ArrayValueTest extends TestCase
{
    /**
     * @covers \array_value
     */
    public function testFunctionReturnsValueAtTheEndOfThePath(): void
    {
        $expected = 'baz';
        $canary = [
            'foo' => [
                'bar' => $expected,
            ],
        ];

        $actual = array_value($canary, 'foo.bar');

        self::assertSame($expected, $actual);
    }

    /**
     * @covers \array_value
     */
    public function testFunctionThrowsArrayKeyPathDoesNotExistException(): void
    {
        self::expectException(ArrayKeyPathDoesNotExistException::class);
        self::expectExceptionCode(ArrayKeyPathDoesNotExistException::CODE);

        $canary = [];

        array_value($canary, 'foo');
    }

    /**
     * @covers \array_value
     */
    public function testFunctionThrowsExceptionIfPathPartTerminatesInNonArrayValue(): void
    {
        self::expectException(ArrayPathTerminatesEarlyException::class);
        self::expectExceptionCode(ArrayPathTerminatesEarlyException::CODE);

        $canary = [
            'foo' => false,
        ];

        array_value($canary, 'foo.bar');
    }

    /**
     * @covers \array_value
     */
    public function testFunctionReturnsArrayIfPathIsEmpty(): void
    {
        $expected = [
            'foo' => new stdClass(),
        ];

        $actual = array_value($expected, '');

        self::assertSame($expected, $actual);

        $actual = array_value($expected, ' ');

        self::assertSame($expected, $actual);

        $actual = array_value($expected, '.');

        self::assertSame($expected, $actual);
    }
}
