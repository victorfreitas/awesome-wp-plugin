<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Facades;

/**
 * HookRegistrar facade.
 *
 * @see \Awesome\Infrastructure\Supports\HookRegistrar
 *
 * @method static void boot(object|string $target)
 */
final class HookRegistrar extends Facade
{
    protected static function facadeAccessor(): string
    {
        return 'hook.registrar';
    }
}
