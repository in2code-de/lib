<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Double;

class FactoryTestClassFour
{
    /** @var string */
    public $foo;

    public function __construct(string $foo = 'bar')
    {
        $this->foo = $foo;
    }
}
