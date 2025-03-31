<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Repositories;

use Awesome\Domain\Interfaces\DatabaseManagerInterface;
use Awesome\Infrastructure\Facades\RequireFile;

class DatabaseManager implements DatabaseManagerInterface
{
    public function createTable(string|array $queries, bool $execute = true): array
    {
        if (! function_exists('dbDelta')) {
            RequireFile::once(path: \ABSPATH . 'wp-admin/includes/upgrade.php');
        }

        return \dbDelta($queries, $execute);
    }
}
