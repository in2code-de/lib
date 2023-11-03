<?php

/**
 * @noinspection PhpUnitTestsInspection
 */

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use CoStack\Lib\Exceptions\TypeErrorException;
use PHPUnit\Framework\TestCase;

use function array_filter;
use function CoStack\Lib\filter;

use const CoStack\Lib\FILTER_INVERT;
use const CoStack\Lib\FILTER_MATCH_LOOSE;

class FilterTest extends TestCase
{
    /**
     * @return array<string, array<int, array|mixed>>
     */
    public function filterConfigurationDataProvider(): array
    {
        return [
            'remove "not foo" from array' => [
                ['bar', 'foo', 'bar', 'foo'],
                'foo',
                0,
                [1 => 'foo', 3 => 'foo'],
            ],
            'invert remove "not foo" from array' => [
                ['bar', 'foo', 'bar', 'foo'],
                'foo',
                FILTER_INVERT,
                [0 => 'bar', 2 => 'bar'],
            ],
            'remove any "non falsy" value' => [
                ['bar', [], 0, 'false', false, '0', 'foo', null, 'foo'],
                false,
                FILTER_MATCH_LOOSE,
                [1 => [], 2 => 0, 4 => false, 5 => '0', 7 => null],

            ],
            'invert remove any "non falsy" value' => [
                ['bar', [], 0, 'bar', '0', 'foo', null, 'foo'],
                false,
                FILTER_MATCH_LOOSE | FILTER_INVERT,
                [0 => 'bar', 3 => 'bar', 5 => 'foo', 7 => 'foo'],
            ],
            'edge case empty probe' => [
                [],
                false,
                FILTER_MATCH_LOOSE | FILTER_INVERT,
                [],
            ],
        ];
    }

    /**
     * @covers       \CoStack\Lib\filter
     * @dataProvider filterConfigurationDataProvider
     *
     * @param array<mixed> $canary
     * @param int|float|string|bool $specimen
     * @param int $flags
     * @param array<mixed> $expected
     */
    public function testFunctionReturnsExpectedValue(
        array $canary,
        $specimen,
        int $flags,
        array $expected
    ): void {
        $filter = filter($specimen, $flags);
        $actual = array_filter($canary, $filter);
        self::assertSame($expected, $actual);
    }

    /**
     * @covers \CoStack\Lib\filter
     * @uses \CoStack\Lib\Exceptions\TypeErrorException
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public function testFunctionThrowsExceptionIfSpecimenTypeIsNotAllowed(): void
    {
        self::expectException(TypeErrorException::class);
        self::expectExceptionCode(TypeErrorException::CODE);

        // @phpstan-ignore-next-line
        filter(null);
    }
}
