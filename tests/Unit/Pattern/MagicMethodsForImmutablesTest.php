<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Pattern;

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
    public function testTraitRemovesValueIfWithoutPropertyIsCalled(): void
    {
        $canary = new Immutable('foo');

        $canary = $canary->withoutFoo();

        self::assertNull($canary->foo);
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

    /**
     * @covers \CoStack\LibTests\Unit\Pattern\Double\Immutable::__call
     */
    public function testTraitAddsIsMethodForAllProperties(): void
    {
        $canary = new Immutable(null, null, true);
        $actual = $canary->isBoo();

        $this->assertTrue($actual);
    }

    /**
     * @covers \CoStack\LibTests\Unit\Pattern\Double\Immutable::__call
     */
    public function testTraitIsMethodAlwaysReturnsBool(): void
    {
        $canary = new Immutable(null, null, null);
        $actual = $canary->isBoo();

        $this->assertFalse($actual);
    }

    /**
     * @covers \CoStack\LibTests\Unit\Pattern\Double\Immutable::__call
     */
    public function testTraitGetAndHasBehaveDifferentOnNullValue(): void
    {
        $canary = new Immutable(null);
        $this->assertNull($canary->getFoo());
        $this->assertFalse($canary->hasFoo());
    }
}
