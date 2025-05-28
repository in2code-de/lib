<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Double;

use JetBrains\PhpStorm\Pure;

class FactoryTestClassThree
{
    /**
     * @param array<mixed> $arrayArg
     */
    #[Pure]
    public function __construct(
        public int $intArg,
        public string $stringArg,
        public array $arrayArg,
        public bool $boolArg,
        public float $floatArg,
    ) {}
}
