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
 * @method static withoutFoo()
 * @method static withoutBar()
 * @method bool isBoo()
 * @method bool hasBoo()
 * @method bool getBoo()
 * @method static withBoo(?bool $baz)
 * @method static withoutBoo()
 */
class Immutable
{
    use MagicMethodsForImmutables;

    /** @var string|null */
    public $foo;

    /** @var string|null */
    public $bar;

    /** @var bool|null */
    public $boo;

    public function __construct(?string $foo = '', ?string $bar = null, ?bool $boo = null)
    {
        $this->foo = $foo;
        $this->bar = $bar;
        $this->boo = $boo;
    }
}
