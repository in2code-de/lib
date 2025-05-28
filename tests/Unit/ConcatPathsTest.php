<?php

/** @noinspection PhpUnitTestsInspection */

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function CoStack\Lib\concat_paths;

use const DIRECTORY_SEPARATOR;

#[CoversFunction('CoStack\Lib\concat_paths')]
class ConcatPathsTest extends TestCase
{
    public function testFunctionSupportsProtocols(): void
    {
        $actual = concat_paths('vfs://foo/', '/bar');

        self::assertSame('vfs://foo/bar', $actual);
    }

    public function testFunctionReturnsEmptyStringForEmptyPaths(): void
    {
        $actual = concat_paths();

        self::assertSame('', $actual);
    }

    public function testFunctionReturnsPathWithoutDuplicateDirectorySeparator(): void
    {
        $actual = concat_paths(DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR);

        self::assertSame(DIRECTORY_SEPARATOR, $actual);
    }

    public function testFunctionPreservesAbsoluteness(): void
    {
        $actual = concat_paths(DIRECTORY_SEPARATOR, 'foo');

        self::assertSame('/foo', $actual);
    }

    /**
     * @param array<string, array<int, (string|array<int, string>)>> $paths
     */
    #[DataProvider('pathsForConcatenationDataProvider')]
    public function testFunctionReturnsPathsAsExpected(array $paths, string $expected): void
    {
        $actual = concat_paths(...$paths);

        self::assertSame($expected, $actual);
    }

    /** @return array<string, array<int, (string|array<int, string>)>> */
    public static function pathsForConcatenationDataProvider(): array
    {
        $dirSep = DIRECTORY_SEPARATOR;
        $doubleDs = $dirSep . $dirSep;
        return [
            'no args' => [[], ''],
            'one empty' => [[''], ''],
            'two empty' => [['', ''], ''],
            'more empty' => [['', '', '', ''], ''],
            'one ds' => [[$dirSep], $dirSep],
            'two ds' => [[$dirSep, $dirSep], $dirSep],
            'one double ds' => [[$doubleDs], $dirSep],
            'two double ds' => [[$doubleDs, $doubleDs], $dirSep],
            'actual paths' => [
                [
                    '/foo/',
                    '/path/to',
                    'another/part/',
                    '//',
                    '/foo/',
                ],
                '/foo/path/to/another/part/foo/',
            ],
        ];
    }
}
