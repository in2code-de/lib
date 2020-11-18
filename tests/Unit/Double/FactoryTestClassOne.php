<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Double;

class FactoryTestClassOne
{
    /** @var mixed[] */
    public array $args;

    public function __construct()
    {
        $this->args = func_get_args();
    }
}
