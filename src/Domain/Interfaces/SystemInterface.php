<?php

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface SystemInterface
{
    public function checkPhpVersion(string $phpVersion): bool;

    public function checkDatabaseVersion(string $mysqlVersion): bool;
}
