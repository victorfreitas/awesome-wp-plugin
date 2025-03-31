<?php

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface DatabaseManagerInterface
{
    public function createTable(string|array $queries, bool $execute = true): array;
}
