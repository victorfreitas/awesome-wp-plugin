<?php

declare(strict_types=1);

namespace Awesome\Tests\Unit\Infrastructure\Repositories;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Brain\Monkey;
use Awesome\Domain\Interfaces\RequireFileInterface;
use Awesome\Infrastructure\Facades\Container;
use Awesome\Tests\Unit\AbstractUnitTestCase;
use Awesome\Infrastructure\Repositories\DatabaseManager;

class DatabaseManagerTest extends AbstractUnitTestCase
{
    #[Test]
    #[TestDox('Must validate the createTable method')]
    public function createTable(): void
    {
        $queries = 'create table';

        Monkey\Functions\expect('dbDelta')
            ->times(3)
            ->with(\Mockery::anyOf($queries, [$queries]), \Mockery::anyOf(true, false))
            ->andReturn([]);

        $databaseManager = new DatabaseManager();

        $this->assertIsArray($databaseManager->createTable(queries: $queries));
        $this->assertIsArray($databaseManager->createTable(queries: [$queries]));
        $this->assertEmpty($databaseManager->createTable(queries: [$queries], execute: false));
    }

    #[Test]
    #[TestDox('Must validate the createTable method')]
    public function createTableRequireOnce(): void
    {
        $container = new Container();
        $requireFile = \Mockery::mock(RequireFileInterface::class);

        $container->bind('util.require.file', static fn () => $requireFile);
        $container->boot();

        $requireFile->expects('once')
            ->once()
            ->with(\ABSPATH . 'wp-admin/includes/upgrade.php');

        $databaseManager = new DatabaseManager();

        $this->expectException(\Error::class);
        $this->expectExceptionMessageMatches('/Call to undefined function dbDelta\(\)/');

        $databaseManager->createTable(queries: 'create table');
    }
}
