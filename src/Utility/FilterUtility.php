<?php

declare(strict_types=1);

namespace CoStack\Lib\Utility;

use Closure;
use Exception;
use JetBrains\PhpStorm\Pure;

use function CoStack\Lib\filter;

/**
 * @codeCoverageIgnore
 */
class FilterUtility
{
    /**
     * @param int|float|string|bool $specimen
     * @param int $flags
     * @return Closure
     * @throws Exception
     */
    #[Pure]
    public static function filter(int|float|string|bool $specimen, int $flags = 0): Closure
    {
        return filter($specimen, $flags);
    }
}
