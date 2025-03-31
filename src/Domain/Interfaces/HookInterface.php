<?php

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface HookInterface
{
    public function add(string $hook, callable $callback, int $priority = 10, int $acceptedArgs = 1): bool;

    public function remove(string $hook, callable $callback, int $priority = 10): bool;

    public function removeAll(string $hook, int $priority = 10): bool;

    public function current(): string;

    public function did(string $hook): int;

    public function has(string $hook, callable $callback): bool|int;
}
