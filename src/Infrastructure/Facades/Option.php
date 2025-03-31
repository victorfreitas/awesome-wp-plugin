<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Facades;

/**
 * Option facade.
 *
 * @method static mixed get(string $name, mixed $defaults = null)
 * @method static bool add(string $name, mixed $value)
 * @method static bool update(string $name, mixed $value)
 * @method static bool remove(string $name)
 */
class Option extends Facade
{
    protected static function facadeAccessor(): string
    {
        return 'option';
    }
}
