<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Pattern;

use CoStack\LibTests\Unit\Pattern\Double\ClassWithSingletonTrait;
use PHPUnit\Framework\TestCase;
use ReflectionMethod;

/**
 * @coversDefaultClass \CoStack\Lib\Pattern\Singleton
 */
class SingletonTest extends TestCase
{
    /**
     * @covers ::__construct
     * @covers ::getInstance
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function testClassWithSingletonAlwaysReturnsTheSameInstance(): void
    {
        $singleton1 = ClassWithSingletonTrait::getInstance();
        $singleton2 = ClassWithSingletonTrait::getInstance();

        self::assertSame($singleton1, $singleton2);
    }

    /**
     * @coversNothing
     */
    public function testClassWithSingletonHasPrivateConstructor(): void
    {
        $methodReflection = new ReflectionMethod(ClassWithSingletonTrait::class, '__construct');

        self::assertTrue($methodReflection->isPrivate());
    }
}
