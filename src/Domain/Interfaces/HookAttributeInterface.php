<?php

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface HookAttributeInterface
{
    public function add(\Closure $callback): void;
}
