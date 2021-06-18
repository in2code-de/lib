<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use CoStack\Lib\Exceptions\MissingConstructorArgumentException;
use CoStack\Lib\Exceptions\MissingPropertyOrConstructorArgumentException;
use CoStack\Lib\Exceptions\PropertyNotPublicException;
use CoStack\LibTests\Unit\Double\FactoryTestClassSeven;
use CoStack\LibTests\Unit\Double\FactoryTestClassThree;
use PHPUnit\Framework\TestCase;

use function CoStack\Lib\factory;

class FactoryExceptionsTest extends TestCase
{
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
    public function testFunctionThrowsExceptionIfArgumentIsNotInConstructorOrProperty(): void
    {
        self::expectException(MissingPropertyOrConstructorArgumentException::class);
        self::expectExceptionCode(MissingPropertyOrConstructorArgumentException::CODE);

        factory(FactoryTestClassSeven::class, ['foo' => 'faz', '_does_not_exist' => 'blob']);
    }

    /**
     * @covers \CoStack\Lib\factory
     */
    public function testFunctionThrowsExceptionIfPropertyIsProtected(): void
    {
        self::expectException(PropertyNotPublicException::class);
        self::expectExceptionCode(PropertyNotPublicException::CODE);

        factory(FactoryTestClassSeven::class, ['foo' => 'faz', 'beng' => 'blob']);
    }

    /**
     * @covers \CoStack\Lib\factory
     */
    public function testFunctionThrowsExceptionIfPropertyIsPrivate(): void
    {
        self::expectException(PropertyNotPublicException::class);
        self::expectExceptionCode(PropertyNotPublicException::CODE);

        factory(FactoryTestClassSeven::class, ['foo' => 'faz', 'fump' => 'blob']);
    }
}
