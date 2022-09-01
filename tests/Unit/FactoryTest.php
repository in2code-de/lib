<?php

/**
 * @noinspection PhpUnitTestsInspection
 * @noinspection PhpUnhandledExceptionInspection
 */

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use CoStack\LibTests\Unit\Double\FactoryTestClassFive;
use CoStack\LibTests\Unit\Double\FactoryTestClassFour;
use CoStack\LibTests\Unit\Double\FactoryTestClassOne;
use CoStack\LibTests\Unit\Double\FactoryTestClassSeven;
use CoStack\LibTests\Unit\Double\FactoryTestClassSix;
use CoStack\LibTests\Unit\Double\FactoryTestClassThree;
use CoStack\LibTests\Unit\Double\FactoryTestClassTwo;
use PHPUnit\Framework\TestCase;

use function CoStack\Lib\factory;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class FactoryTest extends TestCase
{
    /**
     * @covers \CoStack\Lib\factory
     */
    public function testFunctionCreatesNewInstanceOfClassWithoutArgs(): void
    {
        $object = factory(FactoryTestClassOne::class);
        self::assertInstanceOf(FactoryTestClassOne::class, $object);
    }

    /**
     * @covers \CoStack\Lib\factory
     */
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

    /**
     * @covers \CoStack\Lib\factory
     */
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

    /**
     * @covers \CoStack\Lib\factory
     */
    public function testFunctionCreatesInstanceWithDefaultArgumentsIfNoneAreProvided(): void
    {
        $object = factory(FactoryTestClassFour::class);
        self::assertSame('bar', $object->foo);
    }

    /**
     * @covers \CoStack\Lib\factory
     */
    public function testFunctionCreatesInstanceOfClassWithoutConstructor(): void
    {
        $object = factory(FactoryTestClassFive::class);

        self::assertInstanceOf(FactoryTestClassFive::class, $object);
    }

    /**
     * @covers \CoStack\Lib\factory
     */
    public function testFunctionMapsArgumentsToPublicProperties(): void
    {
        $object = factory(FactoryTestClassSix::class, ['foo' => 'baz', 'bar' => 13]);

        self::assertSame($object->foo, 'baz');
        self::assertSame($object->bar, 13);
    }

    /**
     * @covers \CoStack\Lib\factory
     */
    public function testFunctionMapsArgumentsToConstructorAndPublicProperties(): void
    {
        $object = factory(FactoryTestClassSeven::class, ['foo' => 'boo', 'bar' => 24.85]);

        self::assertSame($object->foo, 'boo');
        self::assertSame($object->bar, 24.85);
    }
}
