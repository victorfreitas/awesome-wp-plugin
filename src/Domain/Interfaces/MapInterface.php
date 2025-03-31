<?php

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface MapInterface extends \ArrayAccess
{
    public function __construct(array $items);

    public function set(string $name, mixed $value): self;

    public function get(string $name, mixed $defaults = null): mixed;

    public function has(string $name): bool;
}
