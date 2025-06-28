<?php

/**
 * @noinspection PhpUnhandledExceptionInspection
 */

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use ArrayIterator;
use CoStack\Lib\Exceptions\ImpreciseParameterTypeException;
use CoStack\Lib\Exceptions\MissingConstructorArgumentException;
use CoStack\Lib\Exceptions\MissingPropertyOrConstructorArgumentException;
use CoStack\Lib\Exceptions\PropertyNotPublicException;
use CoStack\LibTests\Unit\Double\FactoryTestClassEight;
use CoStack\LibTests\Unit\Double\FactoryTestClassNine;
use CoStack\LibTests\Unit\Double\FactoryTestClassSeven;
use CoStack\LibTests\Unit\Double\FactoryTestClassThree;
use IteratorAggregate;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use stdClass;
use Traversable;
use TypeError;

use function CoStack\Lib\factory;

/**
 * @SuppressWarnings("PHPMD.CouplingBetweenObjects")
 */
#[CoversFunction('CoStack\Lib\factory')]
#[UsesClass(MissingConstructorArgumentException::class)]
#[UsesClass(PropertyNotPublicException::class)]
#[UsesClass(ImpreciseParameterTypeException::class)]
#[UsesClass(MissingPropertyOrConstructorArgumentException::class)]
class FactoryExceptionsTest extends TestCase
{
    public function testFunctionThrowsExceptionForMissingNonOptionalArgument(): void
    {
        $this->expectException(MissingConstructorArgumentException::class);
        $this->expectExceptionCode(MissingConstructorArgumentException::CODE);

        factory(FactoryTestClassThree::class);
    }

    public function testFunctionThrowsExceptionIfArgumentIsNotInConstructorOrProperty(): void
    {
        $this->expectException(MissingPropertyOrConstructorArgumentException::class);
        $this->expectExceptionCode(MissingPropertyOrConstructorArgumentException::CODE);

        factory(FactoryTestClassSeven::class, ['foo' => 'faz', '_does_not_exist' => 'blob']);
    }

    public function testFunctionThrowsExceptionIfPropertyIsProtected(): void
    {
        $this->expectException(PropertyNotPublicException::class);
        $this->expectExceptionCode(PropertyNotPublicException::CODE);

        factory(FactoryTestClassSeven::class, ['foo' => 'faz', 'beng' => 'blob']);
    }

    public function testFunctionThrowsExceptionIfPropertyIsPrivate(): void
    {
        $this->expectException(PropertyNotPublicException::class);
        $this->expectExceptionCode(PropertyNotPublicException::CODE);

        factory(FactoryTestClassSeven::class, ['foo' => 'faz', 'fump' => 'blob']);
    }

    public function testFunctionThrowsExceptionIfPropertyIsImprecise(): void
    {
        $this->expectException(ImpreciseParameterTypeException::class);
        $this->expectExceptionCode(ImpreciseParameterTypeException::CODE);

        factory(FactoryTestClassEight::class, ['foo' => 0.123]);
    }

    public function testFunctionAcceptsUnionTypes(): void
    {
        $this->expectException(TypeError::class);

        $argument = new class extends stdClass implements IteratorAggregate {
            public function getIterator(): Traversable
            {
                return new ArrayIterator();
            }
        };

        factory(FactoryTestClassNine::class, ['foo' => $argument]);
    }
}
