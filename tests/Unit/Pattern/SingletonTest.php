<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Pattern;

use CoStack\Lib\Pattern\Singleton;
use CoStack\LibTests\Unit\Pattern\Double\ClassWithSingletonTrait;
use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

#[CoversTrait(Singleton::class)]
class SingletonTest extends TestCase
{
    public function testClassWithSingletonAlwaysReturnsTheSameInstance(): void
    {
        $singleton1 = ClassWithSingletonTrait::getInstance();
        $singleton2 = ClassWithSingletonTrait::getInstance();

        self::assertSame($singleton1, $singleton2);
    }

    public function testClassWithSingletonHasPrivateConstructor(): void
    {
        $methodReflection = new ReflectionMethod(ClassWithSingletonTrait::class, '__construct');

        self::assertTrue($methodReflection->isPrivate());
    }
}
