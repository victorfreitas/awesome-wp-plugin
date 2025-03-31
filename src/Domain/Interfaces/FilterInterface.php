<?php

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface FilterInterface extends HookInterface
{
    public function apply(string $hook, mixed $value, mixed ...$args): mixed;

    public function applyRefArray(string $hook, array $args): mixed;
}
