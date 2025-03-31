<?php

declare(strict_types=1);

namespace Awesome\Tests\Shared;

abstract class AbstractDatabaseTestCase extends AbstractTestCase
{
    protected static ?\PDO $db = null;

    protected function connection(): ?\PDO
    {
        return self::$db;
    }

    public static function setUpBeforeClass(): void
    {
        parent::setUpBeforeClass();

        // @phpcs:disable WordPress.DB.RestrictedClasses.mysql__PDO
        if (env('pdo.dsn') && env('pdo.username')) {
            self::$db = new \PDO(
                dsn: env('pdo.dsn'),
                username: env('pdo.username'),
                password: env('pdo.password'),
                options: [
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
                ]
            );
        }
    }

    public static function tearDownAfterClass(): void
    {
        parent::tearDownAfterClass();

        self::$db = null;
    }
}
