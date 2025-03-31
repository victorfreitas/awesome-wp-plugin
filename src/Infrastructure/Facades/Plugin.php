<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Facades;

/**
 * Plugin facade.
 *
 * @see \Awesome\Presentation\Utils\Plugin
 *
 * @method static string pluginUrl(string $path)
 * @method static string pluginPath(string $file)
 * @method static int|string fileVersion(string $file)
 * @method static void addMenuPage(\Awesome\Domain\Interfaces\MenuPageInterface $menuPage)
 * @method static bool isMainPage()
 * @method static string adminUrl(string $path, ?string $page = null)
 */
class Plugin extends Facade
{
    protected static function facadeAccessor(): string
    {
        return 'plugin';
    }
}
