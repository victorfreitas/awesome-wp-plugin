<?php

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface ConfigInterface extends BootableInterface
{
    public function set(string $name, mixed $value): self;

    public function get(string $name, mixed $defaults = null): mixed;

    public function has(string $name): bool;

    public function version(): string;

    public function pluginFile(): string;

    public function rootPath(): string;

    public function fromRoot(string $name): array|string|null;

    public function pathFromRoot(string $name): ?string;

    public function external(string $name, mixed $defaults = null): mixed;

    public function isExternal(string $name): bool;
}
