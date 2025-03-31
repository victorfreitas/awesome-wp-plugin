<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Utils;

use Awesome\Domain\Constants\Version;
use Awesome\Domain\Interfaces\SystemInterface;

final readonly class System implements SystemInterface
{
    public function checkPhpVersion(string $phpVersion = Version::PHP): bool
    {
        return \version_compare(PHP_VERSION, $phpVersion, '>=');
    }

    public function checkDatabaseVersion(string $mysqlVersion = Version::MYSQL): bool
    {
        /**
         * WP Core wpdb class.
         *
         * @var \wpdb $wpdb
         */
        global $wpdb;

        return \version_compare($wpdb->db_version(), $mysqlVersion, '>=');
    }
}
