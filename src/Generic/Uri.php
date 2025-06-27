<?php

declare(strict_types=1);

namespace CoStack\Lib\Generic;

use CoStack\Lib\Exceptions\InvalidUriException;
use CoStack\Lib\Pattern\MagicMethodsForImmutables;
use Stringable;

use function array_key_exists;
use function http_build_query;
use function ltrim;
use function parse_str;
use function parse_url;
use function str_ends_with;

/**
 * @method null|string getScheme()
 * @method null|string getHost()
 * @method null|int getPort()
 * @method null|string getUser()
 * @method null|string getPass()
 * @method null|string getPath()
 * @method null|string getQuery()
 * @method null|string getFragment()
 * @method bool hasScheme()
 * @method bool hasHost()
 * @method bool hasPort()
 * @method bool hasUser()
 * @method bool hasPass()
 * @method bool hasPath()
 * @method bool hasQuery()
 * @method bool hasFragment()
 * @method Uri withScheme(?string $scheme)
 * @method Uri withHost(?string $host)
 * @method Uri withPort(?int $port)
 * @method Uri withUser(?string $user)
 * @method Uri withPass(?string $pass)
 * @method Uri withPath(?string $path)
 * @method Uri withQuery(?string $query)
 * @method Uri withFragment(?string $fragment)
 * @method Uri withoutScheme()
 * @method Uri withoutHost()
 * @method Uri withoutPort()
 * @method Uri withoutUser()
 * @method Uri withoutPass()
 * @method Uri withoutPath()
 * @method Uri withoutQuery()
 * @method Uri withoutFragment()
 */
class Uri implements Stringable
{
    use MagicMethodsForImmutables;

    // https://github.com/PHPCSStandards/PHP_CodeSniffer/issues/734 not yet solved
    // phpcs:disable
    private ?string $scheme;
    private ?string $host;
    private ?int $port;
    private ?string $user;
    private ?string $pass;
    private ?string $path;
    private ?string $query;
    private ?string $fragment;

    // phpcs:enable

    public function __construct(string $uri = '')
    {
        $uriParts = parse_url($uri);
        if (false === $uriParts) {
            throw new InvalidUriException($uri);
        }
        $this->scheme = $uriParts['scheme'] ?? null;
        $this->host = $uriParts['host'] ?? null;
        $this->port = $uriParts['port'] ?? null;
        $this->user = $uriParts['user'] ?? null;
        $this->pass = $uriParts['pass'] ?? null;
        $this->path = $uriParts['path'] ?? null;
        $this->query = $uriParts['query'] ?? null;
        $this->fragment = $uriParts['fragment'] ?? null;
    }

    /**
     * @return array<array<mixed>|string>
     */
    public function getQueryParts(): array
    {
        $query = $this->getQuery();
        if (null === $query) {
            return [];
        }
        $result = [];
        parse_str($query, $result);
        return $result;
    }

    public function hasQueryPart(string $name): bool
    {
        return array_key_exists($name, $this->getQueryParts());
    }

    /**
     * @return array<mixed>|string
     */
    public function getQueryPart(string $name, mixed $default = null): array|string
    {
        return $this->getQueryParts()[$name] ?? $default;
    }

    public function withQueryPart(string $name, mixed $value): Uri
    {
        $queryParts = $this->getQueryParts();
        $queryParts[$name] = $value;
        $query = http_build_query($queryParts);
        return $this->withQuery($query);
    }

    public function withoutQueryPart(string $name): Uri
    {
        $queryParts = $this->getQueryParts();
        unset($queryParts[$name]);
        $query = http_build_query($queryParts);
        return $this->withQuery($query);
    }

    /**
     * @SuppressWarnings("PHPMD.CyclomaticComplexity")
     * @SuppressWarnings("PHPMD.NPathComplexity")
     * @SuppressWarnings("PHPMD.ElseExpression")
     */
    public function __toString(): string
    {
        $uri = '';

        if (null !== $this->scheme) {
            $uri .= $this->scheme . ':';
        }

        $userInfo = null;

        if (null !== $this->user) {
            $userInfo = $this->user;
            if (null !== $this->pass) {
                $userInfo .= ':' . $this->pass;
            }
        }

        $authority = $this->host;

        if ($userInfo !== null) {
            $authority = $userInfo . '@' . $authority;
        }

        if ($this->port !== null) {
            $authority .= ':' . $this->port;
        }

        if (null !== $authority || 'file' === $this->scheme) {
            $uri .= '//' . $authority;
        }

        if (null !== $this->path) {
            if (empty($uri) || str_ends_with($uri, ':')) {
                $uri .= $this->path;
            } else {
                $uri .= '/' . ltrim($this->path, '/');
            }
        }

        if (null !== $this->query) {
            $uri .= '?' . $this->query;
        }

        if (null !== $this->fragment) {
            $uri .= '#' . $this->fragment;
        }

        return $uri;
    }
}
