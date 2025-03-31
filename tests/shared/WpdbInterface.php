<?php

declare(strict_types=1);

namespace Awesome\Tests\Shared;

// @phpcs:disable
interface WpdbInterface
{
    public function get_charset_collate(): string;

    public function db_version(): string;

    public function __get(string $property): mixed;
}
// @phpcs:enable
