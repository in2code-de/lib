<?php

declare(strict_types=1);

namespace CoStack\LibTests\Unit\Pattern\Double;

use CoStack\Lib\Pattern\MagicMethodsForImmutables;

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
class Immutable
{
    use MagicMethodsForImmutables;

    public ?string $foo;
    public ?string $bar;
    public ?bool $boo;

    public function __construct(?string $foo = '', ?string $bar = null, ?bool $boo = null)
    {
        $this->foo = $foo;
        $this->bar = $bar;
        $this->boo = $boo;
    }
}
