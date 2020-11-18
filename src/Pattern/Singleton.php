<?php

declare(strict_types=1);

namespace CoStack\Lib\Pattern;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
trait Singleton
{
    /** @var self */
    private static $instance;

    final private function __construct()
    {
    }

    public static function getInstance(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
