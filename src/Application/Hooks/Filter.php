<?php

declare(strict_types=1);

namespace Awesome\Application\Hooks;

use Awesome\Domain\Interfaces\FilterInterface;

final readonly class Filter implements FilterInterface
{
    public function add(string $hook, callable $callback, int $priority = 10, int $acceptedArgs = 1): bool
    {
        return \add_filter($hook, $callback, $priority, $acceptedArgs);
    }

    public function remove(string $hook, callable $callback, int $priority = 10): bool
    {
        return \remove_filter($hook, $callback, $priority);
    }

    public function removeAll(string $hook, int $priority = 10): bool
    {
        return \remove_all_filters($hook, $priority);
    }

    public function has(string $hook, callable $callback): bool|int
    {
        return \has_filter($hook, $callback);
    }

    public function did(string $hook): int
    {
        return \did_filter($hook);
    }

    public function current(): string
    {
        return \current_filter() ?: '';
    }

    public function apply(string $hook, mixed $value, mixed ...$args): mixed
    {
        return \apply_filters($hook, $value, ...$args);
    }

    public function applyRefArray(string $hook, array $args): mixed
    {
        return \apply_filters_ref_array($hook, $args);
    }
}
