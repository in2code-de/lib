<?php

/**
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace CoStack\Lib\Utility;

use function CoStack\Lib\concat_paths;
use function CoStack\Lib\mkdir_deep;

/**
 * @codeCoverageIgnore
 */
class FileSystemUtility
{
    public static function concat(string ...$paths): string
    {
        return concat_paths(...$paths);
    }

    /**
     * @param string $path
     * @param int|null $mode
     * @return bool
     */
    public static function mkdirDeep(string $path, int $mode = null): bool
    {
        return mkdir_deep($path, $mode);
    }
}
