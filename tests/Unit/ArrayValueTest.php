<?php

/**
 * @noinspection PhpUnitTestsInspection
 * @noinspection PhpUnhandledExceptionInspection
 */

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use ArrayAccess;
use ArrayObject;
use CoStack\Lib\Exceptions\ArrayKeyPathDoesNotExistException;
use CoStack\Lib\Exceptions\ArrayPathTerminatesEarlyException;
use Exception;
use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;
use stdClass;

use function array_key_exists;
use function CoStack\Lib\array_value;

#[CoversFunction('CoStack\Lib\array_value')]
#[UsesClass(ArrayKeyPathDoesNotExistException::class)]
#[UsesClass(ArrayPathTerminatesEarlyException::class)]
class ArrayValueTest extends TestCase
{
    public function testFunctionReturnsValueAtTheEndOfThePath(): void
    {
        $expected = 'baz';
        $canary = [
            'foo' => [
                'bar' => $expected,
            ],
        ];

        $actual = array_value($canary, 'foo.bar');

        self::assertSame($expected, $actual);
    }

    public function testFunctionThrowsArrayKeyPathDoesNotExistExceptionForArray(): void
    {
        $this->expectException(ArrayKeyPathDoesNotExistException::class);
        $this->expectExceptionCode(ArrayKeyPathDoesNotExistException::CODE);

        $canary = [];

        array_value($canary, 'foo');
    }

    public function testFunctionThrowsArrayKeyPathDoesNotExistExceptionForArrayAccess(): void
    {
        $this->expectException(ArrayKeyPathDoesNotExistException::class);
        $this->expectExceptionCode(ArrayKeyPathDoesNotExistException::CODE);

        $canary = ['foo' => new ArrayObject()];

        array_value($canary, 'foo.baz');
    }

    public function testFunctionThrowsExceptionIfPathPartTerminatesInNonArrayValue(): void
    {
        $this->expectException(ArrayPathTerminatesEarlyException::class);
        $this->expectExceptionCode(ArrayPathTerminatesEarlyException::CODE);

        $canary = [
            'foo' => false,
        ];

        array_value($canary, 'foo.bar');
    }

    public function testFunctionReturnsArrayIfPathIsEmpty(): void
    {
        $expected = [
            'foo' => new stdClass(),
        ];

        $actual = array_value($expected, '');

        self::assertSame($expected, $actual);

        $actual = array_value($expected, ' ');

        self::assertSame($expected, $actual);

        $actual = array_value($expected, '.');

        self::assertSame($expected, $actual);
    }

    public function testFunctionsSupportsArrayAccessInterface(): void
    {
        $values = [
            'bar' => 'baz',
        ];

        $canary = new class ($values) implements ArrayAccess {
            /**
             * @param array<string, string> $values
             */
            public function __construct(protected array $values) {}

            /**
             * @param array-key $offset
             * @noinspection PhpMixedReturnTypeCanBeReducedInspection
             */
            public function offsetGet(mixed $offset): mixed
            {
                return $this->values[$offset];
            }

            /**
             * @param array-key $offset
             */
            public function offsetExists(mixed $offset): bool
            {
                return array_key_exists($offset, $this->values);
            }

            /**
             * @param array-key $offset
             */
            public function offsetSet(mixed $offset, mixed $value): void
            {
                throw new Exception('Not implemented');
            }

            /**
             * @param array-key $offset
             */
            public function offsetUnset(mixed $offset): void
            {
                throw new Exception('Not implemented');
            }
        };

        $value = [
            'foo' => $canary,
        ];

        $expected = 'baz';
        $path = 'foo.bar';

        $actual = array_value($value, $path);

        self::assertSame($expected, $actual);
    }
}
