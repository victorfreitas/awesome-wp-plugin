<?php

declare(strict_types=1);

namespace Awesome\Tests\Unit\Infrastructure\Utils;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\TestDox;
use Awesome\Tests\Unit\AbstractUnitTestCase;
use Awesome\Infrastructure\Utils\System;
use Awesome\Domain\Constants\Version;
use Awesome\Domain\Interfaces\SystemInterface;
use Awesome\Tests\Shared\WpdbInterface;

class SystemTest extends AbstractUnitTestCase
{
    #[Test]
    #[TestDox('Must validate the class implements the interface')]
    public function checkClassImplementsInterface(): void
    {
        $this->assertInstanceOf(SystemInterface::class, new System());
    }

    #[Test]
    #[TestDox('Must validate the checkPhpVersion method')]
    public function checkPhpVersion(): void
    {
        $system = new System();

        $this->assertTrue($system->checkPhpVersion());
        $this->assertFalse($system->checkPhpVersion(phpVersion: '9.3'));
    }

    #[Test]
    #[TestDox('Must validate the checkDatabaseVersion method')]
    public function checkDatabaseVersion(): void
    {
        global $wpdb;

        $system = new System();
        $wpdb = $this->createMock(WpdbInterface::class);

        $wpdb->expects($this->exactly(2))
            ->method('db_version')
            ->willReturn(Version::MYSQL);

        $this->assertTrue($system->checkDatabaseVersion());
        $this->assertFalse($system->checkDatabaseVersion(mysqlVersion: '9.3'));
    }
}
