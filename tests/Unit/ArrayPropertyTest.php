<?php

/**
 * @noinspection NonSecureUniqidUsageInspection
 * @noinspection PhpUnitTestsInspection
 * @noinspection PhpUnhandledExceptionInspection
 */

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use CoStack\Lib\Exceptions\ArrayContainsNonObjectValueException;
use CoStack\Lib\Exceptions\PropertyMustBePropertyNameOrCallable;
use JetBrains\PhpStorm\ArrayShape;
use PHPUnit\Framework\TestCase;
use stdClass;

use function array_count_values;
use function CoStack\Lib\array_property;
use function CoStack\Lib\array_value;
use function func_get_args;
use function property_exists;
use function sprintf;
use function uniqid;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 *
 * PHPMD generates a lot of false positives in this test
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 * @SuppressWarnings(PHPMD.UndefinedVariable)
 */
class ArrayPropertyTest extends TestCase
{
    /**
     * @covers \CoStack\Lib\array_property
     */
    public function testFunctionReturnsEmptyArrayForEmptyArray(): void
    {
        $actual = array_property([], null);

        self::assertSame([], $actual);
    }

    /**
     * @covers \CoStack\Lib\array_property
     */
    public function testFunctionReturnsPublicPropertyValuesByString(): void
    {
        $testObject = new class {
            public string $foo;
        };

        $expected = [
            uniqid(),
            uniqid(),
            uniqid(),
        ];

        $canary = [];
        for ($i = 0; $i <= 2; $i++) {
            $object = clone $testObject;
            $object->foo = $expected[$i];
            $canary[] = $object;
        }

        $actual = array_property($canary, 'foo');

        self::assertSame($expected, $actual);
    }

    /**
     * @covers       \CoStack\Lib\array_property
     * @noinspection PhpPropertyOnlyWrittenInspection
     */
    public function testFunctionReturnsPrivatePropertyValuesByString(): void
    {
        $testObject = new class {
            /** @phpstan-ignore-next-line */
            private string $foo;

            public function setFoo(string $value): void
            {
                $this->foo = $value;
            }
        };

        $expected = [
            uniqid(),
            uniqid(),
            uniqid(),
        ];

        $canary = [];
        for ($i = 0; $i <= 2; $i++) {
            $object = clone $testObject;
            $object->setFoo($expected[$i]);
            $canary[] = $object;
        }

        $actual = array_property($canary, 'foo');

        self::assertSame($expected, $actual);
    }

    /**
     * @covers       \CoStack\Lib\array_property
     * @noinspection PhpUnusedPrivateFieldInspection
     * @noinspection PhpUnused
     */
    public function testFunctionDoesNotInvokeGetter(): void
    {
        $calls = [];
        $mock = new class ($calls) {
            /**
             * @phpstan-ignore-next-line
             */
            private string $foo = 'bar';

            /**
             * @param string[] $calls
             * @phpstan-ignore-next-line
             * @noinspection PhpPropertyOnlyWrittenInspection
             */
            public function __construct(private array &$calls)
            {
            }

            /** @noinspection PhpUnused */
            public function getFoo(): void
            {
                $this->calls[] = 'getFoo';
            }

            /** @noinspection PhpUnused */
            public function isFoo(): void
            {
                $this->calls[] = 'isFoo';
            }

            /** @noinspection PhpUnused */
            public function hasFoo(): void
            {
                $this->calls[] = 'hasFoo';
            }
        };

        array_property([$mock], 'foo');

        foreach (array_count_values($calls) as $method => $count) {
            self::fail(
                sprintf('Method %s was expected to be called 0 times, actually called %d times.', $method, $count),
            );
        }

        self::assertEmpty($calls);
    }

    /**
     * @covers       \CoStack\Lib\array_property
     * @noinspection PhpPropertyOnlyWrittenInspection
     */
    public function testFunctionInvokedOnlyWithIndexKeyIndexesArray(): void
    {
        $testObject = new class {
            /** @phpstan-ignore-next-line */
            private string $foo;

            public function setFoo(string $value): void
            {
                $this->foo = $value;
            }
        };

        $canaryValues = [
            uniqid(),
            uniqid(),
            uniqid(),
        ];

        $expected = [];

        $canary = [];
        for ($i = 0; $i <= 2; $i++) {
            $object = clone $testObject;
            $object->setFoo($canaryValues[$i]);
            $canary[] = $object;
            $expected[$canaryValues[$i]] = $object;
        }

        $actual = array_property($canary, null, 'foo');

        self::assertSame($expected, $actual);
    }

    /**
     * @covers \CoStack\Lib\array_property
     */
    public function testFunctionReturnsValuesReturnedByClosure(): void
    {
        $testObject = new class {
            private string $foo;

            public function setFoo(string $foo): void
            {
                $this->foo = $foo;
            }

            /** @noinspection PhpUnused */
            public function getFoo(): string
            {
                return $this->foo;
            }
        };

        $returnValues = [
            1 => uniqid(),
            2 => uniqid(),
            3 => uniqid(),
        ];
        $expected =  [
            $returnValues[1],
            $returnValues[2],
            $returnValues[3],
        ];

        $canary = [];
        for ($i = 0; $i <= 2; $i++) {
            $object = clone $testObject;
            $object->setFoo($expected[$i]);
            $canary[] = $object;
        }

        $mock = $this->getMockBuilder(stdClass::class)
                     ->addMethods(['__invoke'])
                     ->getMock();
        $invocationRule = $this->exactly(3);
        /** @noinspection MockingMethodsCorrectnessInspection */
        $mock->expects($invocationRule)
             ->method('__invoke')
             ->willReturnCallback(static fn() => $returnValues[$invocationRule->getInvocationCount()]);

        /**
         * @var callable $mock
         * @return mixed
         */
        $mockWrapper = static fn() => $mock(...func_get_args());

        $actual = array_property($canary, $mockWrapper);

        self::assertSame($expected, $actual);
    }

    /** @return array<string, array<int, (string|callable(object): string)>> */
    #[ArrayShape(shape: [
        'p-string, ik-string' => "string[]",
        'p-closure, ik-string' => "array",
        'p-string, ik-closure' => "array",
        'p-closure, ik-closure' => "\Closure[]",
    ])]
    public function propertyAndIndexKeyMatrixProvider(): array
    {
        $fooGetter = static function (object $object): string {
            if (property_exists($object, 'foo')) {
                return $object->foo;
            }
            return '';
        };
        $barGetter = static function (object $object): string {
            if (property_exists($object, 'bar')) {
                return $object->bar;
            }
            return '';
        };
        return [
            'p-string, ik-string' => ['foo', 'bar'],
            'p-closure, ik-string' => [$fooGetter, 'bar'],
            'p-string, ik-closure' => ['foo', $barGetter],
            'p-closure, ik-closure' => [$fooGetter, $barGetter],
        ];
    }

    /**
     * @covers       \CoStack\Lib\array_property
     *
     * @dataProvider propertyAndIndexKeyMatrixProvider
     */
    public function testFunctionWithPropertyAndIndexKeyWillReturnIndexedArray(
        string|callable $property,
        string|callable $indexKey,
    ): void {
        $testObject = new class {
            public string $foo;
            public string $bar;
        };

        $expected = [
            'foo' => 'bar',
            'baz' => 'beng',
            'faz' => 'boo',
        ];

        $canary = [];
        foreach ($expected as $bar => $foo) {
            $object = clone $testObject;
            $object->foo = $foo;
            $object->bar = $bar;
            $canary[] = $object;
        }

        $actual = array_property($canary, $property, $indexKey);

        self::assertSame($expected, $actual);
    }

    /**
     * @covers \CoStack\Lib\array_property
     * @uses   \CoStack\Lib\Exceptions\PropertyMustBePropertyNameOrCallable
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public function testFunctionThrowsExceptionIfBothPropertyAndKeyAreNotSet(): void
    {
        $this->expectException(PropertyMustBePropertyNameOrCallable::class);
        $this->expectExceptionCode(PropertyMustBePropertyNameOrCallable::CODE);

        /**
         * @phpstan-ignore-next-line
         * @noinspection PhpParamsInspection
         */
        array_property(['foo'], null);
    }

    /**
     * @covers \CoStack\Lib\array_property
     * @uses   \CoStack\Lib\Exceptions\ArrayContainsNonObjectValueException
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public function testFunctionThrowsExceptionIfValueIsNotAnObject(): void
    {
        $this->expectException(ArrayContainsNonObjectValueException::class);
        $this->expectExceptionCode(ArrayContainsNonObjectValueException::CODE);

        /**
         * @phpstan-ignore-next-line
         * @noinspection PhpParamsInspection
         */
        array_property(['foo'], 'foo');
    }
}
