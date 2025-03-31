<?php

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface HookRegistrarInterface
{
    public function run(object|string $target): void;
}
