<?php

/**
 * @noinspection PhpUnitTestsInspection
 * @noinspection PhpUnhandledExceptionInspection
 */

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use CoStack\Lib\Exceptions\MissingConstructorArgumentException;
use CoStack\Lib\Exceptions\MissingPropertyOrConstructorArgumentException;
use CoStack\Lib\Exceptions\PropertyNotPublicException;
use CoStack\LibTests\Unit\Double\FactoryTestClassSeven;
use CoStack\LibTests\Unit\Double\FactoryTestClassThree;
use PHPUnit\Framework\TestCase;

use function CoStack\Lib\factory;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class FactoryExceptionsTest extends TestCase
{
    /**
     * @covers \CoStack\Lib\factory
     */
    public function testFunctionThrowsExceptionForMissingNonOptionalArgument(): void
    {
        $this->expectException(MissingConstructorArgumentException::class);
        $this->expectExceptionCode(MissingConstructorArgumentException::CODE);

        factory(FactoryTestClassThree::class);
    }

    /**
     * @covers \CoStack\Lib\factory
     */
    public function testFunctionThrowsExceptionIfArgumentIsNotInConstructorOrProperty(): void
    {
        $this->expectException(MissingPropertyOrConstructorArgumentException::class);
        $this->expectExceptionCode(MissingPropertyOrConstructorArgumentException::CODE);

        factory(FactoryTestClassSeven::class, ['foo' => 'faz', '_does_not_exist' => 'blob']);
    }

    /**
     * @covers \CoStack\Lib\factory
     */
    public function testFunctionThrowsExceptionIfPropertyIsProtected(): void
    {
        $this->expectException(PropertyNotPublicException::class);
        $this->expectExceptionCode(PropertyNotPublicException::CODE);

        factory(FactoryTestClassSeven::class, ['foo' => 'faz', 'beng' => 'blob']);
    }

    /**
     * @covers \CoStack\Lib\factory
     */
    public function testFunctionThrowsExceptionIfPropertyIsPrivate(): void
    {
        $this->expectException(PropertyNotPublicException::class);
        $this->expectExceptionCode(PropertyNotPublicException::CODE);

        factory(FactoryTestClassSeven::class, ['foo' => 'faz', 'fump' => 'blob']);
    }
}
