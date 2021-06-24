<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Pattern;

use CoStack\Lib\Exceptions\ArgumentCountErrorException;
use CoStack\Lib\Exceptions\BadMethodCallException;
use CoStack\LibTests\Unit\Pattern\Double\Immutable;
use PHPUnit\Framework\TestCase;

class MagicMethodsForImmutablesTest extends TestCase
{
    /**
     * @covers \CoStack\LibTests\Unit\Pattern\Double\Immutable::__call
     */
    public function testTraitAddsGetMethodForAllProperties(): void
    {
        $canary = new Immutable('baz', 'boo');

        self::assertSame('baz', $canary->getFoo());
        self::assertSame('boo', $canary->getBar());
    }

    /**
     * @covers \CoStack\LibTests\Unit\Pattern\Double\Immutable::__call
     */
    public function testTraitAddsHasMethodForAllProperties(): void
    {
        $canary = new Immutable(null, 'boo');

        self::assertFalse($canary->hasFoo());
        self::assertTrue($canary->hasBar());
    }

    /**
     * @covers \CoStack\LibTests\Unit\Pattern\Double\Immutable::__call
     */
    public function testTraitAddsWithMethodForAllProperties(): void
    {
        $canary = new Immutable(null);

        $withFoo = $canary->withFoo('faz');
        self::assertNotSame($canary, $withFoo);
        self::assertNull($canary->getFoo());
        self::assertSame('faz', $withFoo->getFoo());
    }

    /**
     * @covers \CoStack\LibTests\Unit\Pattern\Double\Immutable::__call
     */
    public function testTraitThrowsExceptionIfGetPropertyDoesNotExist(): void
    {
        $canary = new Immutable();

        self::expectException(BadMethodCallException::class);
        self::expectExceptionCode(BadMethodCallException::CODE);

        // @phpstan-ignore-next-line
        $canary->getBaz();
    }

    /**
     * @covers \CoStack\LibTests\Unit\Pattern\Double\Immutable::__call
     */
    public function testTraitThrowsExceptionIfWithPropertyDoesNotExist(): void
    {
        $canary = new Immutable();

        self::expectException(BadMethodCallException::class);
        self::expectExceptionCode(BadMethodCallException::CODE);

        // @phpstan-ignore-next-line
        $canary->withBaz();
    }

    /**
     * @covers \CoStack\LibTests\Unit\Pattern\Double\Immutable::__call
     */
    public function testTraitThrowsExceptionIfWithMethodMissesArgument(): void
    {
        $canary = new Immutable();

        self::expectException(ArgumentCountErrorException::class);
        self::expectExceptionCode(ArgumentCountErrorException::CODE);

        // @phpstan-ignore-next-line
        $canary->withBar();
    }

    /**
     * @covers \CoStack\LibTests\Unit\Pattern\Double\Immutable::__call
     */
    public function testTraitRemovesValueIfWithoutPropertyIsCalled(): void
    {
        $canary = new Immutable();
        $canary->foo = 'foo';

        $canary = $canary->withoutFoo();

        self::assertNull($canary->foo);
    }

    /**
     * @covers \CoStack\LibTests\Unit\Pattern\Double\Immutable::__call
     */
    public function testTraitThrowsExceptionIfWithoutPropertyDoesNotExist(): void
    {
        $canary = new Immutable();

        self::expectException(BadMethodCallException::class);
        self::expectExceptionCode(BadMethodCallException::CODE);

        // @phpstan-ignore-next-line
        $canary->withoutBaz();
    }

    /**
     * @covers \CoStack\LibTests\Unit\Pattern\Double\Immutable::__call
     */
    public function testTraitClonesTheObjectWhenWithIsCalled(): void
    {
        $canary = new Immutable();
        $actual = $canary->withBar(null);

        $this->assertNotSame($canary, $actual);
    }

    /**
     * @covers \CoStack\LibTests\Unit\Pattern\Double\Immutable::__call
     */
    public function testTraitClonesTheObjectWhenWithoutIsCalled(): void
    {
        $canary = new Immutable();
        $actual = $canary->withoutBar();

        $this->assertNotSame($canary, $actual);
    }
}
