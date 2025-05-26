<?php

declare(strict_types=1);

namespace CoStack\Lib\Utility;

use function CoStack\Lib\cgi_parse_str;

/**
 * @codeCoverageIgnore
 */
class UriUtility
{
    /**
     * @param string $string
     * @return array<string, string|array<string, string>>
     */
    public static function cgiParseStr(string $string): array
    {
        return cgi_parse_str($string);
    }
}
