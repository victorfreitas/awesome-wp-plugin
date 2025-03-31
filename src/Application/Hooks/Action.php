<?php

declare(strict_types=1);

namespace Awesome\Application\Hooks;

use Awesome\Domain\Interfaces\ActionInterface;

final readonly class Action implements ActionInterface
{
    public function add(string $hook, callable $callback, int $priority = 10, int $acceptedArgs = 1): bool
    {
        return \add_action($hook, $callback, $priority, $acceptedArgs);
    }

    public function remove(string $hook, callable $callback, int $priority = 10): bool
    {
        return \remove_action($hook, $callback, $priority);
    }

    public function removeAll(string $hook, int $priority = 10): bool
    {
        return \remove_all_actions($hook, $priority);
    }

    public function has(string $hook, callable $callback): bool|int
    {
        return \has_action($hook, $callback);
    }

    public function did(string $hook): int
    {
        return \did_action($hook);
    }

    public function current(): string
    {
        return \current_action() ?: '';
    }

    public function emit(string $hook, mixed ...$args): self
    {
        \do_action($hook, ...$args);

        return $this;
    }

    public function emitRefArray(string $hook, array $args): self
    {
        \do_action_ref_array($hook, $args);

        return $this;
    }

    public function registerActivation(string $file, callable $callback): self
    {
        \register_activation_hook($file, $callback);

        return $this;
    }

    public function registerDeactivation(string $file, callable $callback): self
    {
        \register_deactivation_hook($file, $callback);

        return $this;
    }

    public function loadTextdomain(string $file): bool
    {
        \unload_textdomain('awesome');

        return \load_plugin_textdomain(
            'awesome',
            false,
            \plugin_basename(\dirname($file)) . '/i18n/languages'
        );
    }
}
