<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Double;

class FactoryTestClassThree
{
    /**
     * @param int $intArg
     * @param string $stringArg
     * @param mixed[] $arrayArg
     * @param bool $boolArg
     * @param float $floatArg
     */
    // phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
    public function __construct(
        public int $intArg,
        public string $stringArg,
        public array $arrayArg,
        public bool $boolArg,
        public float $floatArg,
    ) {
        // phpcs:enable Generic.WhiteSpace.ScopeIndent.IncorrectExact
    }
}
