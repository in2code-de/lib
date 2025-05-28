<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Pattern;

use CoStack\Lib\Pattern\MagicMethodsForImmutables;
use CoStack\LibTests\Unit\Pattern\Double\Immutable;
use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\TestCase;

#[CoversTrait(MagicMethodsForImmutables::class)]
class MagicMethodsForImmutablesTest extends TestCase
{
    public function testTraitAddsGetMethodForAllProperties(): void
    {
        $canary = new Immutable('baz', 'boo');

        self::assertSame('baz', $canary->getFoo());
        self::assertSame('boo', $canary->getBar());
    }

    public function testTraitAddsHasMethodForAllProperties(): void
    {
        $canary = new Immutable(null, 'boo');

        self::assertFalse($canary->hasFoo());
        self::assertTrue($canary->hasBar());
    }

    public function testTraitAddsWithMethodForAllProperties(): void
    {
        $canary = new Immutable(null);

        $withFoo = $canary->withFoo('faz');
        self::assertNotSame($canary, $withFoo);
        self::assertNull($canary->getFoo());
        self::assertSame('faz', $withFoo->getFoo());
    }

    public function testTraitRemovesValueIfWithoutPropertyIsCalled(): void
    {
        $canary = new Immutable('foo');

        $canary = $canary->withoutFoo();

        self::assertNull($canary->foo);
    }

    public function testTraitClonesTheObjectWhenWithIsCalled(): void
    {
        $canary = new Immutable();
        $actual = $canary->withBar(null);

        $this->assertNotSame($canary, $actual);
    }

    public function testTraitClonesTheObjectWhenWithoutIsCalled(): void
    {
        $canary = new Immutable();
        $actual = $canary->withoutBar();

        $this->assertNotSame($canary, $actual);
    }

    public function testTraitAddsIsMethodForAllProperties(): void
    {
        $canary = new Immutable(null, null, true);
        $actual = $canary->isBoo();

        $this->assertTrue($actual);
    }

    public function testTraitIsMethodAlwaysReturnsBool(): void
    {
        $canary = new Immutable(null, null, null);
        $actual = $canary->isBoo();

        $this->assertFalse($actual);
    }

    public function testTraitGetAndHasBehaveDifferentOnNullValue(): void
    {
        $canary = new Immutable(null);
        $this->assertNull($canary->getFoo());
        $this->assertFalse($canary->hasFoo());
    }
}
