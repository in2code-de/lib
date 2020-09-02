<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit;

use PHPUnit\Framework\TestCase;

use function concat_paths;
use function escapeshellarg;
use function exec;
use function mkdir_deep;
use function sys_get_temp_dir;
use function uniqid;

class MkdirDeepTest extends TestCase
{
    /**
     * @covers \mkdir_deep
     */
    public function testFunctionCreatesDirectory(): void
    {
        $prefix = concat_paths(sys_get_temp_dir(), uniqid());
        $path = concat_paths($prefix, '/bar/baz/boo');
        self::assertDirectoryDoesNotExist($prefix);
        self::assertDirectoryDoesNotExist($path);
        $success = mkdir_deep($path);
        self::assertTrue($success);
        self::assertDirectoryExists($path);
        exec('rm -rf ' . escapeshellarg($prefix));
    }

    /**
     * @covers \mkdir_deep
     */
    public function testFunctionAllowsSettingMode(): void
    {
        $prefix = concat_paths(sys_get_temp_dir(), uniqid());
        $path = concat_paths($prefix, '/bar/baz/boo');
        self::assertDirectoryDoesNotExist($prefix);
        self::assertDirectoryDoesNotExist($path);
        $success = mkdir_deep($path, 0700);
        self::assertTrue($success);
        self::assertDirectoryExists($path);

        self::assertSame('0700', substr(sprintf('%o', fileperms($path)), -4));

        exec('rm -rf ' . escapeshellarg($prefix));
    }
}
