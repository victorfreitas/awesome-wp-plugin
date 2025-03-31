<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Facades;

/**
 * DatabaseManager facade.
 *
 * @method static array|null createTable(string|array $queries, bool $execute = true)
 */
class DatabaseManager extends Facade
{
    protected static function facadeAccessor(): string
    {
        return 'database.manager';
    }
}
