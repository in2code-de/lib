<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Pattern;

use CoStack\Lib\Exceptions\ArgumentCountErrorException;
use CoStack\Lib\Exceptions\BadMethodCallException;
use CoStack\Lib\Pattern\MagicMethodsForImmutables;
use CoStack\LibTests\Unit\Pattern\Double\Immutable;
use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversTrait(MagicMethodsForImmutables::class)]
#[UsesClass(BadMethodCallException::class)]
#[UsesClass(ArgumentCountErrorException::class)]
class MagicMethodsForImmutablesExceptionsTest extends TestCase
{
    public function testTraitThrowsExceptionIfGetPropertyDoesNotExist(): void
    {
        $canary = new Immutable();

        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionCode(BadMethodCallException::CODE);

        /**
         * @noinspection PhpUndefinedMethodInspection
         * @phpstan-ignore method.notFound
         */
        $canary->getBaz();
    }

    public function testTraitThrowsExceptionIfWithPropertyDoesNotExist(): void
    {
        $canary = new Immutable();

        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionCode(BadMethodCallException::CODE);

        /**
         * @noinspection PhpUndefinedMethodInspection
         * @phpstan-ignore method.notFound
         */
        $canary->withBaz();
    }

    public function testTraitThrowsExceptionIfWithMethodMissesArgument(): void
    {
        $canary = new Immutable();

        $this->expectException(ArgumentCountErrorException::class);
        $this->expectExceptionCode(ArgumentCountErrorException::CODE);

        /**
         * @noinspection PhpParamsInspection
         * @phpstan-ignore arguments.count
         */
        $canary->withBar();
    }

    public function testTraitThrowsExceptionIfWithoutPropertyDoesNotExist(): void
    {
        $canary = new Immutable();

        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionCode(BadMethodCallException::CODE);

        /**
         * @noinspection PhpUndefinedMethodInspection
         * @phpstan-ignore method.notFound
         */
        $canary->withoutBaz();
    }
}
