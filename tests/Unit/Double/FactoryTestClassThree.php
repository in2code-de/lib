<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Double;

class FactoryTestClassThree
{
    /** @var int */
    public $intArg;
    /** @var string */
    public $stringArg;
    /** @var mixed[] */
    public $arrayArg;
    /** @var bool */
    public $boolArg;
    /** @var float */
    public $floatArg;

    /**
     * @param int $intArg
     * @param string $stringArg
     * @param mixed[] $arrayArg
     * @param bool $boolArg
     * @param float $floatArg
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
