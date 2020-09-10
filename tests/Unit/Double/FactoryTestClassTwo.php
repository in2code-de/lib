<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Double;

class FactoryTestClassTwo
{
    public int $myValue;

    public function __construct(int $myValue)
    {
        $this->myValue = $myValue;
    }
}
