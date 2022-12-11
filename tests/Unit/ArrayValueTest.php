<?php

/**
 * @noinspection PhpUnitTestsInspection
 * @noinspection PhpUnhandledExceptionInspection
 */

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use ArrayAccess;
use CoStack\Lib\Exceptions\ArrayKeyPathDoesNotExistException;
use CoStack\Lib\Exceptions\ArrayPathTerminatesEarlyException;
use Exception;
use PHPUnit\Framework\TestCase;
use stdClass;

use function array_key_exists;
use function CoStack\Lib\array_value;

class ArrayValueTest extends TestCase
{
    /**
     * @covers \CoStack\Lib\array_value
     */
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

    /**
     * @covers \CoStack\Lib\array_value
     * @uses   \CoStack\Lib\Exceptions\ArrayKeyPathDoesNotExistException
     */
    public function testFunctionThrowsArrayKeyPathDoesNotExistException(): void
    {
        $this->expectException(ArrayKeyPathDoesNotExistException::class);
        $this->expectExceptionCode(ArrayKeyPathDoesNotExistException::CODE);

        $canary = [];

        array_value($canary, 'foo');
    }

    /**
     * @covers \CoStack\Lib\array_value
     * @uses   \CoStack\Lib\Exceptions\ArrayPathTerminatesEarlyException
     */
    public function testFunctionThrowsExceptionIfPathPartTerminatesInNonArrayValue(): void
    {
        $this->expectException(ArrayPathTerminatesEarlyException::class);
        $this->expectExceptionCode(ArrayPathTerminatesEarlyException::CODE);

        $canary = [
            'foo' => false,
        ];

        array_value($canary, 'foo.bar');
    }

    /**
     * @covers \CoStack\Lib\array_value
     */
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

    /**
     * @covers \CoStack\Lib\array_value
     */
    public function testFunctionsSupportsArrayAccessInterface(): void
    {
        $values = [
            'bar' => 'baz',
        ];

        $canary = new class ($values) implements ArrayAccess {
            /**
             * @var array<string, string>
             */
            protected array $values;

            /**
             * @param array<string, string> $values
             */
            public function __construct(array $values)
            {
                $this->values = $values;
            }

            /**
             * @param array-key $offset
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
