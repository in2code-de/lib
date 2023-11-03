<?php

/** @noinspection PhpUnitTestsInspection */

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use PHPUnit\Framework\TestCase;

use function CoStack\Lib\concat_paths;

use const DIRECTORY_SEPARATOR;

class ConcatPathsTest extends TestCase
{
    /**
     * @covers \CoStack\Lib\concat_paths
     */
    public function testFunctionSupportsProtocols(): void
    {
        $actual = concat_paths('vfs://foo/', '/bar');

        self::assertSame('vfs://foo/bar', $actual);
    }

    /**
     * @covers \CoStack\Lib\concat_paths
     */
    public function testFunctionReturnsEmptyStringForEmptyPaths(): void
    {
        $actual = concat_paths();

        self::assertSame('', $actual);
    }

    /**
     * @covers \CoStack\Lib\concat_paths
     */
    public function testFunctionReturnsPathWithoutDuplicateDirectorySeparator(): void
    {
        $actual = concat_paths(DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR);

        self::assertSame(DIRECTORY_SEPARATOR, $actual);
    }

    /**
     * @covers \CoStack\Lib\concat_paths
     */
    public function testFunctionPreservesAbsoluteness(): void
    {
        $actual = concat_paths(DIRECTORY_SEPARATOR, 'foo');

        self::assertSame('/foo', $actual);
    }

    /** @return array<string, array<int, (string|array<int, string>)>> */
    public function pathsForConcatenationDataProvider(): array
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

    /**
     * @covers       \CoStack\Lib\concat_paths
     *
     * @dataProvider pathsForConcatenationDataProvider
     *
     * @param string[] $paths
     */
    public function testFunctionReturnsPathsAsExpected(array $paths, string $expected): void
    {
        $actual = concat_paths(...$paths);

        self::assertSame($expected, $actual);
    }
}
