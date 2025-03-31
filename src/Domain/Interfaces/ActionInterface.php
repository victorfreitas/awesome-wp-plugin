<?php

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface ActionInterface extends HookInterface
{
    public function emit(string $hook, mixed ...$args): self;

    public function emitRefArray(string $hook, array $args): self;

    public function registerActivation(string $file, callable $callback): self;

    public function registerDeactivation(string $file, callable $callback): self;

    public function loadTextdomain(string $file): bool;
}
