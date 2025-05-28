<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Double;

use JetBrains\PhpStorm\Pure;

class FactoryTestClassTwo
{
    #[Pure]
    public function __construct(public int $myValue) {}
}
