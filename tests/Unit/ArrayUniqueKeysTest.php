<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;

use function CoStack\Lib\array_unique_keys;

#[CoversFunction('CoStack\Lib\array_unique_keys')]
class ArrayUniqueKeysTest extends TestCase
{
    public function testFunctionReturnsArrayKeysAsList(): void
    {
        $expected = [1, 2, 3, 'foo', 4, 'bar'];
        $canary1 = [
            1 => 'value',
            2 => 'value',
        ];
        $canary2 = [
            1 => 'buz',
            3 => 'buz',
            'foo' => 'buz',
        ];
        $canary3 = [
            4 => 'feng',
            3 => 'feng',
            'bar' => 'feng',
            'foo' => 'feng',
        ];

        $actual = array_unique_keys($canary1, $canary2, $canary3);

        self::assertSame($expected, $actual);
    }

    public function testFunctionReturnsEmptyArrayForMissingInput(): void
    {
        $expected = [];

        $actual = array_unique_keys();

        self::assertSame($expected, $actual);
    }

    public function testFunctionReturnsEmptyArrayForEmptyInput(): void
    {
        $expected = [];

        $actual = array_unique_keys([]);

        self::assertSame($expected, $actual);
    }
}
