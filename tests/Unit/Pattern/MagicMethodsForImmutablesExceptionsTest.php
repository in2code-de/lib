<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Pattern;

use CoStack\Lib\Exceptions\ArgumentCountErrorException;
use CoStack\Lib\Exceptions\BadMethodCallException;
use CoStack\LibTests\Unit\Pattern\Double\Immutable;
use PHPUnit\Framework\TestCase;

class MagicMethodsForImmutablesExceptionsTest extends TestCase
{
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
    public function testTraitThrowsExceptionIfWithoutPropertyDoesNotExist(): void
    {
        $canary = new Immutable();

        self::expectException(BadMethodCallException::class);
        self::expectExceptionCode(BadMethodCallException::CODE);

        // @phpstan-ignore-next-line
        $canary->withoutBaz();
    }
}
