<?php

declare(strict_types=1);

namespace CoStack\Lib\Utility;

use Closure;
use CoStack\Lib\Exceptions\TypeErrorException;

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
     * @throws TypeErrorException
     */
    public static function filter($specimen, int $flags = 0): Closure
    {
        return filter($specimen, $flags);
    }
}
