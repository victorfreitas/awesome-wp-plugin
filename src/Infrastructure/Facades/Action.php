<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Facades;

/**
 * Action facade.
 *
 * @see \Awesome\Application\Hooks\Action
 *
 * @method static self registerActivation(string $file, callable $callback)
 * @method static self registerDeactivation(string $file, callable $callback)
 * @method static self add(
 *  string $hook,
 *  callable $callback,
 *  int $priority = 10,
 *  int $acceptedArgs = 1
 * )
 * @method static self remove(string $hook, callable $callback, int $priority = 10)
 * @method static self removeAll(string $hook, int $priority = 10)
 * @method static self emit(string $hook, mixed ...$args)
 * @method static string current()
 * @method static int did(string $hook)
 * @method static bool has(string $hook, callable $callback)
 * @method static void boot()
 */
class Action extends Facade
{
    protected static function facadeAccessor(): string
    {
        return 'action';
    }
}
