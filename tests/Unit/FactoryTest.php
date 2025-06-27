<?php

/**
 * @noinspection PhpUnitTestsInspection
 * @noinspection PhpUnhandledExceptionInspection
 */

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use ArrayIterator;
use CoStack\LibTests\Unit\Double\FactoryTestClassEight;
use CoStack\LibTests\Unit\Double\FactoryTestClassFive;
use CoStack\LibTests\Unit\Double\FactoryTestClassFour;
use CoStack\LibTests\Unit\Double\FactoryTestClassNine;
use CoStack\LibTests\Unit\Double\FactoryTestClassOne;
use CoStack\LibTests\Unit\Double\FactoryTestClassSeven;
use CoStack\LibTests\Unit\Double\FactoryTestClassSix;
use CoStack\LibTests\Unit\Double\FactoryTestClassThree;
use CoStack\LibTests\Unit\Double\FactoryTestClassTwo;
use IteratorAggregate;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\TestCase;
use stdClass;
use Stringable;
use Traversable;

use function CoStack\Lib\factory;

/**
 * @SuppressWarnings("PHPMD.CouplingBetweenObjects")
 */
#[CoversFunction('CoStack\Lib\factory')]
class FactoryTest extends TestCase
{
    public function testFunctionCreatesNewInstanceOfClassWithoutArgs(): void
    {
        $object = factory(FactoryTestClassOne::class);
        self::assertInstanceOf(FactoryTestClassOne::class, $object);
    }

    public function testFunctionCreatesNewInstanceOfClassWithArgs(): void
    {
        $expected = 15;
        $arguments = [
            'myValue' => $expected,
        ];

        /** @var FactoryTestClassTwo $object */
        $object = factory(FactoryTestClassTwo::class, $arguments);

        self::assertInstanceOf(FactoryTestClassTwo::class, $object);
        self::assertSame($expected, $object->myValue);
    }

    public function testFunctionConvertsArgumentsToExpectedType(): void
    {
        $arguments = [
            'intArg' => '21',
            'stringArg' => 4.957,
            'arrayArg' => 'foo',
            'boolArg' => '1',
            'floatArg' => '58.848beng',
        ];

        /** @var FactoryTestClassThree $object */
        $object = factory(FactoryTestClassThree::class, $arguments);

        self::assertSame(21, $object->intArg);
        self::assertSame('4.957', $object->stringArg);
        self::assertSame(['foo'], $object->arrayArg);
        self::assertTrue($object->boolArg);
        self::assertSame(58.848, $object->floatArg);
    }

    public function testFunctionCreatesInstanceWithDefaultArgumentsIfNoneAreProvided(): void
    {
        $object = factory(FactoryTestClassFour::class);
        self::assertSame('bar', $object->foo);
    }

    public function testFunctionCreatesInstanceOfClassWithoutConstructor(): void
    {
        $object = factory(FactoryTestClassFive::class);

        self::assertInstanceOf(FactoryTestClassFive::class, $object);
    }

    public function testFunctionMapsArgumentsToPublicProperties(): void
    {
        $object = factory(FactoryTestClassSix::class, ['foo' => 'baz', 'bar' => 13]);

        self::assertSame($object->foo, 'baz');
        self::assertSame($object->bar, 13);
    }

    public function testFunctionMapsArgumentsToConstructorAndPublicProperties(): void
    {
        $object = factory(FactoryTestClassSeven::class, ['foo' => 'boo', 'bar' => 24.85]);

        self::assertSame($object->foo, 'boo');
        self::assertSame($object->bar, 24.85);
    }

    public function testFunctionMapsArgumentsToUnionTypesWhichAcceptTheArgument(): void
    {
        $object = factory(FactoryTestClassEight::class, ['foo' => 42]);

        self::assertSame($object->foo, 42);
    }

    public function testFunctionMapsArgumentsToIntersectionTypesWhichAcceptTheArgument(): void
    {
        $argument = new class extends stdClass implements Stringable, IteratorAggregate {
            public function getIterator(): Traversable
            {
                return new ArrayIterator();
            }

            public function __toString(): string
            {
                return 'foo';
            }
        };

        $object = factory(FactoryTestClassNine::class, ['foo' => $argument]);

        self::assertSame($object->foo, $argument);
    }
}
