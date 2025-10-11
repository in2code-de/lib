<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function CoStack\Lib\enumerate;

#[CoversFunction('CoStack\Lib\enumerate')]
class EnumerateTest extends TestCase
{
    /**
     * @return array<string, list<bool|list<string>|string>>
     */
    public static function stringsProvider(): array
    {
        return [
            'empty' => [
                [],
                ' and ',
                false,
                '',
            ],
            'zero' => [
                [''],
                ' and ',
                false,
                '',
            ],
            'one' => [
                ['a'],
                ' and ',
                false,
                'a',
            ],
            'two' => [
                ['a', 'b'],
                ' and ',
                false,
                'a and b',
            ],
            'three' => [
                ['a', 'b', 'c'],
                ' and ',
                false,
                'a, b and c',
            ],
            'oc_empty' => [
                [],
                ' and ',
                true,
                '',
            ],
            'oc_zero' => [
                [''],
                ' and ',
                true,
                '',
            ],
            'oc_one' => [
                ['a'],
                ' and ',
                true,
                'a',
            ],
            'oc_two' => [
                ['a', 'b'],
                ' and ',
                true,
                'a and b',
            ],
            'oc_three' => [
                ['a', 'b', 'c'],
                ' and ',
                true,
                'a, b, and c',
            ],
        ];
    }

    /**
     * @param array<int, string> $strings
     */
    #[DataProvider('stringsProvider')]
    public function testFunctionReturnsSameString(
        array $strings,
        string $glue,
        bool $oxfordComma,
        string $expected,
    ): void {
        self::assertSame($expected, enumerate($glue, $strings, $oxfordComma));
    }
}
