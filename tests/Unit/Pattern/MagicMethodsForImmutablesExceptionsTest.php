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
     * @uses   \CoStack\Lib\Exceptions\BadMethodCallException
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
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

    /**
     * @covers \CoStack\LibTests\Unit\Pattern\Double\Immutable::__call
     * @uses \CoStack\Lib\Exceptions\BadMethodCallException
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
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

    /**
     * @covers \CoStack\LibTests\Unit\Pattern\Double\Immutable::__call
     * @uses   \CoStack\Lib\Exceptions\ArgumentCountErrorException
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
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

    /**
     * @covers \CoStack\LibTests\Unit\Pattern\Double\Immutable::__call
     * @uses   \CoStack\Lib\Exceptions\BadMethodCallException
     * @noinspection PhpUnnecessaryFullyQualifiedNameInspection
     */
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
