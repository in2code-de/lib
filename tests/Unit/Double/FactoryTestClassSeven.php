<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Double;

/**
 * @SuppressWarnings(PHPMD.UnusedPrivateField)
 */
class FactoryTestClassSeven
{
    public string $foo;

    public float $bar;

    protected string $beng;

    private string $fump;

    public function __construct(string $foo)
    {
        $this->foo = $foo;
    }
}
