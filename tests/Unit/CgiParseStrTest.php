<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use PHPUnit\Framework\Attributes\CoversFunction;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use function CoStack\Lib\cgi_parse_str;

#[CoversFunction('CoStack\Lib\cgi_parse_str')]
class CgiParseStrTest extends TestCase
{
    /**
     * @param array<mixed> $expected
     */
    #[DataProvider('stringAndParseResultDataProvider')]
    public function testFunctionParsesStringIntoExpectedArray(string $input, array $expected): void
    {
        $result = cgi_parse_str($input);
        self::assertSame($expected, $result);
    }

    /**
     * @return array<string, list<array<string, list<string>|string>|string>>
     */
    public static function stringAndParseResultDataProvider(): array
    {
        return [
            'empty string' => ['', []],
            'simple string' => ['foo=bar', ['foo' => 'bar']],
            'simple array' => ['foo=bar&foo=baz', ['foo' => ['bar', 'baz']]],
            'complex' => [
                'foo&bar=1&bar=2&bar=3&zap[]=1&zap=2=',
                ['foo' => '', 'bar' => ['1', '2', '3'], 'zap[]' => '1', 'zap' => '2='],
            ],
        ];
    }
}
