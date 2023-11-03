<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Double;

class FactoryTestClassThree
{
    public int $intArg;
    public string $stringArg;
    /** @var mixed[] */
    public array $arrayArg;
    public bool $boolArg;
    public float $floatArg;

    /**
     * @param array<mixed> $arrayArg
     */
    public function __construct(int $intArg, string $stringArg, array $arrayArg, bool $boolArg, float $floatArg)
    {
        $this->intArg = $intArg;
        $this->stringArg = $stringArg;
        $this->arrayArg = $arrayArg;
        $this->boolArg = $boolArg;
        $this->floatArg = $floatArg;
    }
}
