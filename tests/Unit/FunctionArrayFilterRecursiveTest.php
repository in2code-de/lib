<?php

/** @noinspection PhpUnitTestsInspection */

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use CoStack\Lib\Contract\Invokable;
use PHPUnit\Framework\TestCase;

use function CoStack\Lib\array_filter_recursive;
use function func_get_args;

use const ARRAY_FILTER_USE_BOTH;
use const ARRAY_FILTER_USE_KEY;

class FunctionArrayFilterRecursiveTest extends TestCase
{
    /**
     * @covers \CoStack\Lib\array_filter_recursive
     */
    public function testFunctionStopsFilterAtGivenLevel(): void
    {
        $canary = [
            'foo' => [
                'bar' => null,
                'baz' => [
                    'beng' => [
                        'faz' => null,
                        'far' => [
                            'feng' => null,
                            'foo' => [
                                1,
                            ],
                        ],
                    ],
                ],
            ],
        ];
        $expected = [
            'foo' => [
                'baz' => [
                    'beng' => [
                        'far' => [
                            'feng' => null,
                            'foo' => [
                                1,
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $actual = array_filter_recursive($canary, 4);

        self::assertSame($expected, $actual);
    }

    /**
     * @covers \CoStack\Lib\array_filter_recursive
     */
    public function testClosureCanBeUsedAsFilterFunction(): void
    {
        $canary = [
            'foo' => 1,
            'bar' => 2,
            'baz' => 3,
            'beng' => 4,
        ];

        $filter = fn($value): bool => $value < 2 || $value > 3;

        $expected = [
            'foo' => 1,
            'beng' => 4,
        ];

        $actual = array_filter_recursive($canary, -1, $filter);

        self::assertSame($expected, $actual);
    }

    /**
     * @covers \CoStack\Lib\array_filter_recursive
     */
    public function testFunctionSupportsUseKeyFlag(): void
    {
        $canary = [
            'foo' => 1,
            'bar' => 2,
            'baz' => 3,
        ];

        $returnValues = [
            1 => 'foo',
            2 => 'bar',
            3 => 'baz',
        ];

        $mock = $this->getMockBuilder(Invokable::class)->getMock();

        $invocationRule = $this->exactly(3);
        /** @noinspection MockingMethodsCorrectnessInspection */
        $mock->expects($invocationRule)
            ->method('__invoke')
            ->willReturnCallback(static fn(): string => $returnValues[$invocationRule->numberOfInvocations()]);

        /**
         * @return string
         * @var callable $mock
         * @phpstan-ignore varTag.nativeType
         */
        $mockWrapper = static fn(): string => $mock(...func_get_args());

        array_filter_recursive($canary, -1, $mockWrapper, ARRAY_FILTER_USE_KEY);
    }

    /**
     * @covers \CoStack\Lib\array_filter_recursive
     */
    public function testFunctionSupportsUseBothFlag(): void
    {
        $canary = [
            'foo' => 1,
            'bar' => 2,
            'baz' => 3,
        ];

        $returnValues = [
            1 => [1, 'foo'],
            2 => [2, 'bar'],
            3 => [3, 'baz'],
        ];

        $mock = $this->getMockBuilder(Invokable::class)->getMock();
        $invocationRule = $this->exactly(3);
        /** @noinspection MockingMethodsCorrectnessInspection */
        $mock->expects($invocationRule)
            ->method('__invoke')
            ->willReturnCallback(static fn(): array => $returnValues[$invocationRule->numberOfInvocations()]);

        /**
         * @return array
         * @var callable $mock
         * @phpstan-ignore varTag.nativeType
         */
        $mockWrapper = static fn(): array => $mock(...func_get_args());

        array_filter_recursive($canary, -1, $mockWrapper, ARRAY_FILTER_USE_BOTH);
    }
}
