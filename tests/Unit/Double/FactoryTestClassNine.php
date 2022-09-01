<?php

/** @noinspection PhpUnused */

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Double;

use IteratorAggregate;
use JetBrains\PhpStorm\Pure;
use stdClass;
use Stringable;

class FactoryTestClassNine
{
    /**
     * @noinspection PhpMultipleClassDeclarationsInspection
     */
    #[Pure]
    public function __construct(public stdClass&Stringable&IteratorAggregate $foo)
    {
    }
}
