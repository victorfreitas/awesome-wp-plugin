<?php

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface OptionInterface
{
    public function get(string $name, mixed $defaults = null): mixed;

    public function add(string $name, mixed $value): bool;

    public function update(string $name, mixed $value): bool;

    public function delete(string $name): bool;
}
