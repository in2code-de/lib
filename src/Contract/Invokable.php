<?php

declare(strict_types=1);

namespace CoStack\Lib\Contract;

interface Invokable
{
    public function __invoke(): mixed;
}
