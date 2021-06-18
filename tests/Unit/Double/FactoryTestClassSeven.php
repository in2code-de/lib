<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Double;

class FactoryTestClassSeven
{
    /** @var string */
    public $foo;
    /** @var float */
    public $bar;
    /** @var string */
    protected $beng;
    /** @var string */
    private $fump;

    public function __construct(string $foo)
    {
        $this->foo = $foo;
    }
}
