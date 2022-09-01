<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Double;

use JetBrains\PhpStorm\Pure;

class FactoryTestClassThree
{
    /**
     * @param int $intArg
     * @param string $stringArg
     * @param mixed[] $arrayArg
     * @param bool $boolArg
     * @param float $floatArg
     */
    #[Pure]
    public function __construct(
        public int $intArg,
        public string $stringArg,
        public array $arrayArg,
        public bool $boolArg,
        public float $floatArg,
    ) {
    }
}
