<?php

/**
 * @noinspection PhpUnusedPrivateFieldInspection
 * @noinspection PhpUnused
 */

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Double;

use JetBrains\PhpStorm\Pure;

/**
 * @SuppressWarnings("PHPMD.UnusedPrivateField")
 */
class FactoryTestClassSeven
{
    public float $bar;
    protected string $beng;
    /** @phpstan-ignore-next-line */
    private readonly string $fump;

    #[Pure]
    public function __construct(public string $foo) {}
}
