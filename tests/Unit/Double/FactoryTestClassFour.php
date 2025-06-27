<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Double;

use JetBrains\PhpStorm\Pure;

class FactoryTestClassFour
{
    #[Pure]
    public function __construct(public string $foo = 'bar') {}
}
