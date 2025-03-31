<?php

/**
 * Application config class.
 *
 * @package Awesome\Application
 * @since 1.0.0
 */

declare(strict_types=1);

namespace Awesome\Application;

use Awesome\Domain\Constants\Version;
use Awesome\Domain\Interfaces\ConfigInterface;
use Awesome\Domain\Interfaces\MapInterface;
use Awesome\Infrastructure\Facades\Plugin;
use Awesome\Infrastructure\Utils\Map;

final class Config implements ConfigInterface
{
    public function __construct(
        protected readonly string $pluginFile,
        protected readonly MapInterface $map = new Map()
    ) {

        $this->set(name: 'plugin.file', value: $this->pluginFile);
    }

    public function boot(): void
    {
        $this
            ->set(name: 'plugin.title', value: \esc_html__('Awesome', 'awesome'))
            ->set(name: 'plugin.file', value: $this->pluginFile)
            ->set(name: 'plugin.version', value: Version::PLUGIN)
            ->set(name: 'plugin.basename', value: \plugin_basename(file: $this->pluginFile))
            ->set(name: 'plugin.slug', value: \basename(path: $this->pluginFile, suffix: '.php'))
            ->set(
                name: 'plugin.action_links',
                value: 'plugin_action_links_' . $this->get('plugin.basename')
            )
            ->set(
                name: 'plugin.page.url',
                value: Plugin::adminUrl(page: $this->get('plugin.slug'))
            );
    }

    public function set(string $name, mixed $value): self
    {
        $this->map->set(name: $name, value: $value);

        return $this;
    }

    public function get(string $name, mixed $defaults = null): mixed
    {
        return $this->map->get(name: $name, defaults: $defaults);
    }

    public function has(string $name): bool
    {
        return $this->map->has(name: $name);
    }

    public function pathFromRoot(string $name): string|null
    {
        $path = sprintf('%s/config/%s.php', $this->rootPath(), $name);

        return is_readable($path) ? $path : null;
    }

    public function fromRoot(string $name): array|string|null
    {
        $path = $this->pathFromRoot(name: $name);

        return $path ? require $path : null;
    }

    public function pluginFile(): string
    {
        return $this->get('plugin.file');
    }

    public function rootPath(): string
    {
        return \plugin_dir_path($this->pluginFile());
    }

    public function version(): string
    {
        return $this->get('plugin.version');
    }

    public function external(string $name, mixed $defaults = null): mixed
    {
        return match (true) {
            defined($name) => constant($name),
            getenv($name) !== false => getenv($name),
            default => $defaults,
        };
    }

    public function isExternal(string $name): bool
    {
        return defined($name) || getenv($name) !== false;
    }
}
