<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Services;

use Awesome\Domain\Interfaces\OptionInterface;

class Option implements OptionInterface
{
    public function get(string $name, mixed $defaults = null): mixed
    {
        return \get_site_option($name, $defaults);
    }

    public function add(string $name, mixed $value): bool
    {
        return \add_site_option($name, $value);
    }

    public function update(string $name, mixed $value): bool
    {
        return \update_site_option($name, $value);
    }

    public function delete(string $name): bool
    {
        return \delete_site_option($name);
    }
}
