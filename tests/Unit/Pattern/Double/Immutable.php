<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Pattern\Double;

use CoStack\Lib\Pattern\MagicMethodsForImmutables;
use JetBrains\PhpStorm\Pure;

/**
 * @method null|string getFoo()
 * @method null|string getBar()
 * @method bool hasFoo()
 * @method bool hasBar()
 * @method Immutable withFoo(?string $foo)
 * @method Immutable withBar(?string $bar)
 * @method Immutable withoutFoo()
 * @method Immutable withoutBar()
 * @method bool isBoo()
 * @method bool hasBoo()
 * @method bool getBoo()
 * @method Immutable withBoo(?bool $baz)
 * @method Immutable withoutBoo()
 */
#[\JetBrains\PhpStorm\Immutable]
class Immutable
{
    use MagicMethodsForImmutables;

    #[Pure]
    public function __construct(public ?string $foo = '', public ?string $bar = null, public ?bool $boo = null)
    {
    }
}
