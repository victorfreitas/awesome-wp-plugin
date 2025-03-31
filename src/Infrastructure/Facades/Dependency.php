<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Facades;

/**
 * Dependency facade.
 *
 * @method static void addStyle(
 *  string $handle,
 *  string $src,
 *  array $deps = [],
 *  ?string $ver = null,
 *  string $media = 'all'
 * )
 * @method static void addScript(
 *  string $handle,
 *  string $src,
 *  array $deps = [],
 *  ?string $ver = null,
 *  array $args = []
 * )
 * @method static void enqueueScript(
 *  string $handle,
 *  string $src = '',
 *  array $deps = [],
 *  string|bool $ver = false,
 *  array $args = []
 * )
 * @method static void enqueueStyle(
 *  string $handle,
 *  string $src = '',
 *  array $deps = [],
 *  string|bool $ver = false,
 *  string $media = 'all'
 * )
 * @method static string handleName(string $name)
 */
class Dependency extends Facade
{
    protected static function facadeAccessor(): string
    {
        return 'dependency';
    }
}
