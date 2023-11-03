<?php

/**
 * @noinspection PhpUnitTestsInspection
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
use PHPUnit\Framework\TestCase;
use stdClass;
use Traversable;
use TypeError;

use function CoStack\Lib\factory;

/**
 * @SuppressWarnings(PHPMD.CouplingBetweenObjects)
 */
class FactoryExceptionsTest extends TestCase
{
    /**
     * @covers \CoStack\Lib\factory
     * @uses   \CoStack\Lib\Exceptions\MissingConstructorArgumentException
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public function testFunctionThrowsExceptionForMissingNonOptionalArgument(): void
    {
        $this->expectException(MissingConstructorArgumentException::class);
        $this->expectExceptionCode(MissingConstructorArgumentException::CODE);

        factory(FactoryTestClassThree::class);
    }

    /**
     * @covers \CoStack\Lib\factory
     * @uses   \CoStack\Lib\Exceptions\MissingPropertyOrConstructorArgumentException
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public function testFunctionThrowsExceptionIfArgumentIsNotInConstructorOrProperty(): void
    {
        $this->expectException(MissingPropertyOrConstructorArgumentException::class);
        $this->expectExceptionCode(MissingPropertyOrConstructorArgumentException::CODE);

        factory(FactoryTestClassSeven::class, ['foo' => 'faz', '_does_not_exist' => 'blob']);
    }

    /**
     * @covers \CoStack\Lib\factory
     * @uses   \CoStack\Lib\Exceptions\PropertyNotPublicException
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public function testFunctionThrowsExceptionIfPropertyIsProtected(): void
    {
        $this->expectException(PropertyNotPublicException::class);
        $this->expectExceptionCode(PropertyNotPublicException::CODE);

        factory(FactoryTestClassSeven::class, ['foo' => 'faz', 'beng' => 'blob']);
    }

    /**
     * @covers \CoStack\Lib\factory
     * @uses \CoStack\Lib\Exceptions\PropertyNotPublicException
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public function testFunctionThrowsExceptionIfPropertyIsPrivate(): void
    {
        $this->expectException(PropertyNotPublicException::class);
        $this->expectExceptionCode(PropertyNotPublicException::CODE);

        factory(FactoryTestClassSeven::class, ['foo' => 'faz', 'fump' => 'blob']);
    }

    /**
     * @covers \CoStack\Lib\factory
     * @uses   \CoStack\Lib\Exceptions\ImpreciseParameterTypeException
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
    public function testFunctionThrowsExceptionIfPropertyIsImprecise(): void
    {
        $this->expectException(ImpreciseParameterTypeException::class);
        $this->expectExceptionCode(ImpreciseParameterTypeException::CODE);

        factory(FactoryTestClassEight::class, ['foo' => 0.123]);
    }

    /**
     * @covers \CoStack\Lib\factory
     */
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
