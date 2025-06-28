<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use CoStack\Lib\Utility\StringPool;
use PHPUnit\Framework\TestCase;

use function bin2hex;
use function CoStack\Lib\pool;
use function memory_get_usage;
use function random_bytes;

class PoolTest extends TestCase
{
    /**
     * @dataProvider stringProvider
     * @covers \CoStack\Lib\pool
     * @covers \CoStack\Lib\Utility\StringPool
     */
    public function testFunctionReturnsSameString(string $string): void
    {
        self::assertSame($string, pool($string));
    }

    /**
     * @return array<string, array<int, string>>
     */
    public static function stringProvider(): array
    {
        return [
            'empty' => [''],
            'small' => ['a'],
            'medium' => ['abc'],
            'large' => ['abc foo bar baz beng'],
            'special' => ['!"§$%&/()=?`¹²³¼½¬{[]}\\¸´^°-_.:,;·…–|»«¢„”“µæſðđ’^˝łđŋħʒ~¨þ@ſ€¶ŧ←↓ø→'],
            'bytes' => ["\0\0\1\2\3\0\0"],
        ];
    }

    /**
     * @covers \CoStack\Lib\Utility\StringPool
     */
    public function testStringPoolCanBeFlushed(): void
    {
        // Force initialization of the static property
        StringPool::flush();

        // Pre-init variables to prevent them from falsifying memory usage results
        $base = $peak = $localDiff = 0;

        $base = memory_get_usage();

        // We need a big string so PHP actually allocates new RAM.
        // Sometimes it has some free RAM already allocated but free which it seems to use for small strings
        $string = bin2hex(random_bytes(8 ** 3));

        $foo = StringPool::get($string);

        $peak = memory_get_usage();

        self::assertGreaterThan($base, $peak);

        // in phpunit 11 assertGreaterThan allocates memory, we need to account for that
        $localDiff = memory_get_usage();
        $correction = $localDiff - $peak;

        unset($foo, $string);
        StringPool::flush();

        $current = memory_get_usage();
        $current = $current - $correction;

        self::assertSame($base, $current);
    }
}
