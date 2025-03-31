<?php

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

use Psr\Container\ContainerInterface as PsrContainerInterface;

interface ContainerInterface extends PsrContainerInterface, BootableInterface
{
    public function bind(string $accessor, string|callable $concrete): self;

    public function make(string $accessor): object;

    public function bindMany(array $facades): self;
}
