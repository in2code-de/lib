<?php

/**
 * @noinspection PhpUnhandledExceptionInspection
 */

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Generic;

use CoStack\Lib\Exceptions\InvalidUriException;
use CoStack\Lib\Generic\Uri;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

use function rawurldecode;

#[CoversClass(Uri::class)]
#[UsesClass(InvalidUriException::class)]
class UriTest extends TestCase
{
    public function testInvalidUriThrowsException(): void
    {
        $this->expectException(InvalidUriException::class);
        $this->expectExceptionCode(InvalidUriException::CODE);

        new Uri('http:///noop');
    }

    #[DataProvider('validUriStringProvider')]
    public function testToStringReturnsOriginalUrl(string $expected): void
    {
        $uri = new Uri($expected);
        $actual = $uri->__toString();
        self::assertSame($expected, $actual);
    }

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

    public function testGetQueryPartsWithEmptyQuery(): void
    {
        $uri = new Uri('http://example.com/');
        $actual = $uri->getQueryParts();
        self::assertSame([], $actual);
    }

    public function testGetQueryParts(): void
    {
        $uri = new Uri('http://example.com/?foo=bar&baz[]=fump&baz[]=flick');
        $actual = $uri->getQueryParts();
        self::assertSame(['foo' => 'bar', 'baz' => ['fump', 'flick']], $actual);
    }

    public function testHasQueryPartPositive(): void
    {
        $uri = new Uri('http://example.com/?foo=bar&baz[]=fump&baz[]=flick');
        self::assertTrue($uri->hasQueryPart('foo'));
    }

    public function testHasQueryPartNegative(): void
    {
        $uri = new Uri('http://example.com/?foo=bar&baz[]=fump&baz[]=flick');
        self::assertFalse($uri->hasQueryPart('fleep'));
    }

    public function testGetQueryPart(): void
    {
        $uri = new Uri('http://example.com/?foo=bar&baz[]=fump&baz[]=flick');
        $actual = $uri->getQueryPart('baz');
        self::assertSame(['fump', 'flick'], $actual);
    }

    public function testWithQueryPart(): void
    {
        $uri = new Uri('http://example.com/?foo=bar&baz[]=fump&baz[]=flick');
        $actual = $uri->withQueryPart('foo', 'beng');
        self::assertSame('http://example.com/?foo=beng&baz[0]=fump&baz[1]=flick', rawurldecode($actual->__toString()));
    }

    public function testWithoutQueryPart(): void
    {
        $uri = new Uri('http://example.com/?foo=bar&baz[]=fump&baz[]=flick');
        $actual = $uri->withoutQueryPart('foo');
        self::assertSame('http://example.com/?baz[0]=fump&baz[1]=flick', rawurldecode($actual->__toString()));
    }
}
