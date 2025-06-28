<?php

declare(strict_types=1);

namespace CoStack\Lib\Pattern;

use JetBrains\PhpStorm\Pure;

/**
 * @SuppressWarnings("PHPMD.StaticAccess")
 */
trait Singleton
{
    private static self $instance;

    #[Pure]
    private function __construct() {}

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
