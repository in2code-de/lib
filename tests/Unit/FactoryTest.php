<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use CoStack\Lib\Exceptions\MissingConstructorArgumentException;
use CoStack\LibTests\Unit\Double\FactoryTestClassFive;
use CoStack\LibTests\Unit\Double\FactoryTestClassFour;
use CoStack\LibTests\Unit\Double\FactoryTestClassOne;
use CoStack\LibTests\Unit\Double\FactoryTestClassThree;
use CoStack\LibTests\Unit\Double\FactoryTestClassTwo;
use PHPUnit\Framework\TestCase;

use function CoStack\Lib\factory;

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
            'myValue' => $expected
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
            'floatArg' => '58.848asdf',
        ];

        /** @var FactoryTestClassThree $object */
        $object = factory(FactoryTestClassThree::class, $arguments);

        self::assertSame(21, $object->intArg);
        self::assertSame('4.957', $object->stringArg);
        self::assertSame(['foo'], $object->arrayArg);
        self::assertSame(true, $object->boolArg);
        self::assertSame(58.848, $object->floatArg);
    }

    /**
     * @covers \CoStack\Lib\factory
     */
    public function testFunctionThrowsExceptionForMissingNonOptionalArgument(): void
    {
        self::expectException(MissingConstructorArgumentException::class);
        self::expectExceptionCode(MissingConstructorArgumentException::CODE);

        factory(FactoryTestClassThree::class);
    }

    /**
     * @covers \CoStack\Lib\factory
     */
    public function testFunctionCreatesInstanceWithDefaultArgumentsIfNoneAreProvided(): void
    {
        /** @var FactoryTestClassFour $object */
        $object = factory(FactoryTestClassFour::class);
        self::assertSame('bar', $object->foo);
    }

    /**
     * @covers \CoStack\Lib\factory
     */
    public function testFunctionCreatesInstanceOfClassWithoutConstructor(): void
    {
        /** @var FactoryTestClassFive $object */
        $object = factory(FactoryTestClassFive::class);

        self::assertInstanceOf(FactoryTestClassFive::class, $object);
    }
}
