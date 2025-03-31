<?php

declare(strict_types=1);

// @phpcs:disable Inpsyde.CodeQuality.NoRootNamespaceFunctions.Found

if (! function_exists('env')) {
    function env(string $name, mixed $default = null): mixed
    {
        return getenv($name) ?: \Awesome\Tests\Shared\Util::env($name, $default);
    }
}

if (! function_exists('plugin_dir_path')) {
    function plugin_dir_path(string $file): string
    {
        return trailingslashit(dirname($file));
    }
}

if (! function_exists('plugin_basename')) {
    function plugin_basename(string $file): string
    {
        return preg_replace('|^.*/([^/]+/[^/]+)$|', '$1', $file);
    }
}

if (! function_exists('register_activation_hook')) {
    function register_activation_hook(string $file, \Closure $callback): void
    {
        add_action('activate_' . plugin_basename($file), $callback);
    }
}

if (! function_exists('register_deactivation_hook')) {
    function register_deactivation_hook(string $file, \Closure $callback): void
    {
        add_action('deactivate_' . plugin_basename($file), $callback);
    }
}

if (! function_exists('current_action')) {
    function current_action(): string
    {
        return current_filter();
    }
}

if (! function_exists('did_filter')) {
    function did_filter(string $hook): int
    {
        return \Brain\Monkey\Filters\applied($hook);
    }
}

if (! function_exists('remove_all_actions')) {
    function remove_all_actions(string $hook, int $priority = 10): bool
    {
        return \Awesome\Tests\Shared\Util::removeAllHooks(
            type: \Brain\Monkey\Hook\HookStorage::ACTIONS,
            removeHookCallback: 'remove_action',
            hook: $hook,
            priority: $priority
        );
    }
}

if (! function_exists('remove_all_filters')) {
    function remove_all_filters(string $hook, int $priority = 10): bool
    {
        return \Awesome\Tests\Shared\Util::removeAllHooks(
            type: \Brain\Monkey\Hook\HookStorage::FILTERS,
            removeHookCallback: 'remove_filter',
            hook: $hook,
            priority: $priority
        );
    }
}
