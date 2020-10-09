<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Pattern\Double;

use CoStack\Lib\Pattern\MagicMethodsForImmutables;

/**
 * @method null|string getFoo()
 * @method null|string getBar()
 * @method bool hasFoo()
 * @method bool hasBar()
 * @method static withFoo(?string $foo)
 * @method static withBar(?string $bar)
 */
class Immutable
{
    use MagicMethodsForImmutables;

    public ?string $foo;

    public ?string $bar;

    public function __construct(?string $foo = '', ?string $bar = null)
    {
        $this->foo = $foo;
        $this->bar = $bar;
    }
}
