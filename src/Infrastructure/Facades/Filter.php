<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Facades;

/**
 * Filter facade.
 *
 * @method static self add(
 *  string $hook,
 *  callable $callback,
 *  int $priority = 10,
 *  int $acceptedArgs = 1
 * )
 * @method static self remove(string $hook, callable $callback, int $priority = 10)
 * @method static self removeAll(string $hook, int $priority = 10)
 * @method static mixed apply(string $hook, mixed $value, mixed ...$args)
 * @method static string current()
 * @method static int did(string $hook)
 * @method static bool has(string $hook, callable $callback)
 */
class Filter extends Facade
{
    protected static function facadeAccessor(): string
    {
        return 'filter';
    }
}
