<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use CoStack\Lib\Exceptions\ArrayContainsNonObjectValueException;
use CoStack\Lib\Exceptions\PropertyMustBePropertyNameOrCallable;
use PHPUnit\Framework\TestCase;
use stdClass;

use function array_count_values;
use function CoStack\Lib\array_property;
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
            /** @var string */
            public $foo;
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
     * @covers \CoStack\Lib\array_property
     */
    public function testFunctionReturnsPrivatePropertyValuesByString(): void
    {
        $testObject = new class {
            /** @var string */
            public $foo;

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
     * @covers \CoStack\Lib\array_property
     */
    public function testFunctionDoesNotInvokeGetter(): void
    {
        $calls = [];
        $mock = new class ($calls) {
            /** @var string */
            private $foo = 'bar';

            /** @var string[] */
            private $calls;

            /** @param string[] $calls */
            public function __construct(&$calls)
            {
                $this->calls = &$calls;
            }

            public function getFoo(): void
            {
                $this->calls[] = 'getFoo';
            }

            public function isFoo(): void
            {
                $this->calls[] = 'isFoo';
            }

            public function hasFoo(): void
            {
                $this->calls[] = 'hasFoo';
            }
        };

        array_property([$mock], 'foo');

        foreach (array_count_values($calls) as $method => $count) {
            self::fail(
                sprintf('Method %s was expected to be called 0 times, actually called %d times.', $method, $count)
            );
        }

        self::assertEmpty($calls);
    }

    /**
     * @covers \CoStack\Lib\array_property
     */
    public function testFunctionInvokedOnlyWithIndexKeyIndexesArray(): void
    {
        $testObject = new class {
            /** @var string */
            private $foo;

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
            /** @var string */
            private $foo;

            public function setFoo(string $foo): void
            {
                $this->foo = $foo;
            }

            public function getFoo(): string
            {
                return $this->foo;
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

        $mock = $this->getMockBuilder(stdClass::class)
                     ->addMethods(['__invoke'])
                     ->getMock();
        $mock->expects($this->exactly(3))
             ->method('__invoke')
             ->withConsecutive([$canary[0]], [$canary[1]], [$canary[2]])
             ->willReturn($expected[0], $expected[1], $expected[2]);
        $mockWrapper = function () use ($mock) {
            /** @var callable $mock */
            return $mock(...func_get_args());
        };

        $actual = array_property($canary, $mockWrapper);

        self::assertSame($expected, $actual);
    }

    /** @return array<string, array<int, (string|Closure(object): string)>> */
    public function propertyAndIndexKeyMatrixProvider(): array
    {
        $fooGetter = function (object $object): string {
            if (property_exists($object, 'foo')) {
                return $object->foo;
            }
            return '';
        };
        $barGetter = function (object $object): string {
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
     *
     * @param string|callable $property
     * @param string|callable $indexKey
     */
    public function testFunctionWithPropertyAndIndexKeyWillReturnIndexedArray($property, $indexKey): void
    {
        $testObject = new class {
            /** @var string */
            public $foo;

            /** @var string */
            public $bar;
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
     * @uses \CoStack\Lib\Exceptions\PropertyMustBePropertyNameOrCallable
     */
    public function testFunctionThrowsExceptionIfPropertyIsInvalidAndIndexKeyIsNotSet(): void
    {
        self::expectException(PropertyMustBePropertyNameOrCallable::class);
        self::expectExceptionCode(PropertyMustBePropertyNameOrCallable::CODE);

        // @phpstan-ignore-next-line
        array_property([new stdClass()], false);
    }

    /**
     * @covers \CoStack\Lib\array_property
     * @uses   \CoStack\Lib\Exceptions\PropertyMustBePropertyNameOrCallable
     */
    public function testFunctionThrowsExceptionIfIndexKeyIsInvalid(): void
    {
        self::expectException(PropertyMustBePropertyNameOrCallable::class);
        self::expectExceptionCode(PropertyMustBePropertyNameOrCallable::CODE);

        // @phpstan-ignore-next-line
        array_property([new stdClass()], null, false);
    }

    /**
     * @covers \CoStack\Lib\array_property
     * @uses   \CoStack\Lib\Exceptions\PropertyMustBePropertyNameOrCallable
     */
    public function testFunctionThrowsExceptionIfBotPropertyAndKeyAreNotSet(): void
    {
        self::expectException(PropertyMustBePropertyNameOrCallable::class);
        self::expectExceptionCode(PropertyMustBePropertyNameOrCallable::CODE);

        // @phpstan-ignore-next-line
        array_property(['foo'], null, null);
    }

    /**
     * @covers \CoStack\Lib\array_property
     * @uses   \CoStack\Lib\Exceptions\ArrayContainsNonObjectValueException
     */
    public function testFunctionThrowsExceptionIfValueIsNotAnObject(): void
    {
        self::expectException(ArrayContainsNonObjectValueException::class);
        self::expectExceptionCode(ArrayContainsNonObjectValueException::CODE);

        // @phpstan-ignore-next-line
        array_property(['foo'], 'foo');
    }
}
