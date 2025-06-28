<?php

/** @noinspection PhpUnused */

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Double;

use JetBrains\PhpStorm\Pure;

class FactoryTestClassEight
{
    #[Pure]
    public function __construct(public int|string $foo) {}
}
