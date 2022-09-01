<?php

/**
 * @noinspection PhpUnusedPrivateFieldInspection
 * @noinspection PhpUnused
 */

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
    /** @phpstan-ignore-next-line */
    private string $fump;

    public function __construct(string $foo)
    {
        $this->foo = $foo;
    }
}
