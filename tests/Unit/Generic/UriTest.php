<?php

/**
 * @noinspection PhpUnhandledExceptionInspection
 */

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Generic;

use CoStack\Lib\Exceptions\InvalidUriException;
use CoStack\Lib\Generic\Uri;
use PHPUnit\Framework\TestCase;

use function rawurldecode;

/**
 * @coversDefaultClass \CoStack\Lib\Generic\Uri
 */
class UriTest extends TestCase
{
    /**
     * @covers ::__construct
     * @uses \CoStack\Lib\Exceptions\InvalidUriException
     */
    public function testInvalidUriThrowsException(): void
    {
        $this->expectException(InvalidUriException::class);
        $this->expectExceptionCode(InvalidUriException::CODE);

        new Uri('http:///noop');
    }

    /**
     * @dataProvider validUriStringProvider
     * @covers ::__construct
     * @covers ::__toString
     */
    public function testToStringReturnsOriginalUrl(string $expected): void
    {
        $uri = new Uri($expected);
        $actual = $uri->__toString();
        self::assertSame($expected, $actual);
    }

    /**
     * @return array<string, array<int, string>>
     */
    public static function validUriStringProvider(): array
    {
        return [
            'local dot' => ['.'],
            'local string' => ['local'],
            'local protocol' => ['local:'],
            'local protocol path abs' => ['local:/foo'],
            'local protocol path rel' => ['local:foo/'],
            'ssh with user pass port and path' => ['ssh://name:secret@example.com:2022/foo/bar'],
            'query' => ['xxx://yyy:zzz@host.tld/path?query&name=value&array=1&array=2&array=3#fragment'],
        ];
    }

    /**
     * @covers ::__construct
     * @covers ::getQueryParts
     * @uses \CoStack\Lib\Pattern\MagicMethodsForImmutables
     */
    public function testGetQueryPartsWithEmptyQuery(): void
    {
        $uri = new Uri('http://example.com/');
        $actual = $uri->getQueryParts();
        self::assertSame([], $actual);
    }

    /**
     * @covers \CoStack\Lib\Generic\Uri
     * @uses \CoStack\Lib\Pattern\MagicMethodsForImmutables
     */
    public function testGetQueryParts(): void
    {
        $uri = new Uri('http://example.com/?foo=bar&baz[]=fump&baz[]=flick');
        $actual = $uri->getQueryParts();
        self::assertSame(['foo' => 'bar', 'baz' => ['fump', 'flick']], $actual);
    }

    /**
     * @covers ::__construct
     * @covers ::hasQueryPart
     * @covers ::getQueryParts
     * @uses \CoStack\Lib\Pattern\MagicMethodsForImmutables
     */
    public function testHasQueryPartPositive(): void
    {
        $uri = new Uri('http://example.com/?foo=bar&baz[]=fump&baz[]=flick');
        self::assertTrue($uri->hasQueryPart('foo'));
    }

    /**
     * @covers ::__construct
     * @covers ::hasQueryPart
     * @covers ::getQueryParts
     * @uses \CoStack\Lib\Pattern\MagicMethodsForImmutables
     */
    public function testHasQueryPartNegative(): void
    {
        $uri = new Uri('http://example.com/?foo=bar&baz[]=fump&baz[]=flick');
        self::assertFalse($uri->hasQueryPart('fleep'));
    }

    /**
     * @covers ::__construct
     * @covers ::getQueryPart
     * @covers ::getQueryParts
     * @uses \CoStack\Lib\Pattern\MagicMethodsForImmutables
     */
    public function testGetQueryPart(): void
    {
        $uri = new Uri('http://example.com/?foo=bar&baz[]=fump&baz[]=flick');
        $actual = $uri->getQueryPart('baz');
        self::assertSame(['fump', 'flick'], $actual);
    }

    /**
     * @covers \CoStack\Lib\Generic\Uri
     * @uses \CoStack\Lib\Pattern\MagicMethodsForImmutables
     */
    public function testWithQueryPart(): void
    {
        $uri = new Uri('http://example.com/?foo=bar&baz[]=fump&baz[]=flick');
        $actual = $uri->withQueryPart('foo', 'beng');
        self::assertSame('http://example.com/?foo=beng&baz[0]=fump&baz[1]=flick', rawurldecode($actual->__toString()));
    }

    /**
     * @covers \CoStack\Lib\Generic\Uri
     * @uses \CoStack\Lib\Pattern\MagicMethodsForImmutables
     */
    public function testWithoutQueryPart(): void
    {
        $uri = new Uri('http://example.com/?foo=bar&baz[]=fump&baz[]=flick');
        $actual = $uri->withoutQueryPart('foo');
        self::assertSame('http://example.com/?baz[0]=fump&baz[1]=flick', rawurldecode($actual->__toString()));
    }
}
