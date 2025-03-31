<?php

declare(strict_types=1);

namespace Awesome\Presentation\Utils;

use Awesome\Domain\Interfaces\MenuPageInterface;

use function Awesome\config;

final class Plugin
{
    public function addMenuPage(MenuPageInterface $menuPage): void
    {
        \add_menu_page(
            $menuPage->title(),
            $menuPage->menuTitle(),
            $menuPage->capability(),
            $menuPage->slug(),
            $menuPage->callback(),
            $menuPage->icon(),
            $menuPage->position()
        );
    }

    public function pluginUrl(string $path): string
    {
        return \plugins_url($path, config('plugin.file'));
    }

    public function pluginPath(string $file): string
    {
        return \plugin_dir_path(config('plugin.file')) . $file;
    }

    public function fileVersion(string $file): int|string
    {
        return \filemtime($this->pluginPath($file)) ?: config('plugin.version');
    }

    public function isMainPage(): bool
    {
        // phpcs:ignore Inpsyde.CodeQuality.VariablesName.SnakeCaseVar
        global $plugin_page;

        // phpcs:ignore Inpsyde.CodeQuality.VariablesName.SnakeCaseVar
        return config('plugin.slug') === $plugin_page;
    }

    public function adminUrl(string $path = 'admin.php', ?string $page = null): string
    {
        return \admin_url($path . ($page ? '?page=' . $page : ''));
    }
}
