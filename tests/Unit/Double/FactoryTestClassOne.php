<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Double;

use JetBrains\PhpStorm\Pure;

use function func_get_args;

class FactoryTestClassOne
{
    /** @var mixed[] */
    public array $args;

    #[Pure]
    public function __construct()
    {
        $this->args = func_get_args();
    }
}
