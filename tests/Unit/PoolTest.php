<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use CoStack\Lib\Utility\StringPool;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function bin2hex;
use function CoStack\Lib\pool;
use function memory_get_usage;
use function random_bytes;

#[CoversFunction('CoStack\Lib\pool')]
#[CoversClass('CoStack\Lib\Utility\StringPool')]
class PoolTest extends TestCase
{
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

    #[DataProvider('stringProvider')]
    public function testFunctionReturnsSameString(string $string): void
    {
        self::assertSame($string, pool($string));
    }

    public function testStringPoolCanBeFlushed(): void
    {
        // Force initialization of the static property
        StringPool::flush();

        // Pre-init variables to prevent them from falsifying memory usage results
        $base = $peak = 0;

        $base = memory_get_usage();

        // We need a big string so PHP actually allocates new RAM.
        // Sometimes it has some free RAM already allocated but free which it seems to use for small strings
        $string = bin2hex(random_bytes(8 ** 3));

        $foo = StringPool::get($string);

        $peak = memory_get_usage();

        self::assertGreaterThan($base, $peak);

        unset($foo, $string);
        StringPool::flush();

        $current = memory_get_usage();

        self::assertSame($base, $current);
    }
}
