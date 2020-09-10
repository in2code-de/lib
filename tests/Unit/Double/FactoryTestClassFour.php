<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Double;

class FactoryTestClassFour
{
    public string $foo;

    public function __construct(string $foo = 'bar')
    {
        $this->foo = $foo;
    }
}
