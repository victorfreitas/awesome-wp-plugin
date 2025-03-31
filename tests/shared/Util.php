<?php

declare(strict_types=1);

namespace Awesome\Tests\Shared;

class Util
{
    public static function setupPluginBoot(): void
    {
        \Brain\Monkey\Functions\stubs(['admin_url'], 'admin.php');
        \Awesome\Application\Kernel::boot(context: ['plugin.file' => PLUGIN_FILE]);
    }

    public static function environments(): array
    {
        return [
            'plugin.filename' => PLUGIN_FILENAME,
            'plugin.slug' => PLUGIN_SLUG,
            'plugin.basename' => PLUGIN_BASENAME,
            'plugin.title' => PLUGIN_TITLE,
            'plugin.file' => PLUGIN_FILE,
            'plugin.version' => PLUGIN_AWESOME_VERSION,
            'plugin.root' => PLUGIN_ROOT_DIR,
            'pdo.dsn' => getenv('PDO_DSN'),
            'pdo.username' => getenv('PDO_USERNAME'),
            'pdo.password' => getenv('PDO_PASSWORD'),
        ];
    }

    public static function envs(): array
    {
        return [['envs' => static::environments()]];
    }

    public static function env(string $name, mixed $defaults = null): mixed
    {
        $envs = static::environments();

        return $envs[$name] ?? $defaults;
    }

    public static function removeAllHooks(
        string $type,
        callable $removeHookCallback,
        string $hook,
        int $priority = 10
    ): bool {

        $storage = \Brain\Monkey\Container::instance()->hookStorage();
        $reflected = new \ReflectionObject($storage);
        $allStorage = $reflected->getProperty('storage')->getValue($storage);
        $added = \Brain\Monkey\Hook\HookStorage::ADDED;
        $actions = $allStorage[$added][$type][$hook] ?? [];
        $removed = null;

        foreach ($actions as [$actCallback, $actPriority]) :
            if ($actPriority !== $priority) {
                continue;
            }

            $removed = $removeHookCallback($hook, strval($actCallback), $priority);

            if ($removed !== true) {
                return false;
            }
        endforeach;

        return $removed === true;
    }
}
