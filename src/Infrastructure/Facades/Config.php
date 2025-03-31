<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Facades;

/**
 * Config facade.
 *
 * @see \Awesome\Application\Config
 *
 * @method static mixed get(string $name, mixed $defaults = null)
 * @method static bool has(string $name)
 * @method static mixed set(string $name, mixed $value)
 * @method static string version()
 * @method static string pluginFile()
 * @method static array|string|null fromRoot(string $name)
 * @method static mixed external(string $name, mixed $defaults = null)
 */
class Config extends Facade
{
    protected static function facadeAccessor(): string
    {
        return 'config';
    }
}
