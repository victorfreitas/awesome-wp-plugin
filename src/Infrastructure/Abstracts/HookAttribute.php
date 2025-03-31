<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Abstracts;

use Awesome\Domain\Interfaces\HookAttributeInterface;
use Awesome\Domain\Interfaces\HookInterface;

use function Awesome\config;

abstract class HookAttribute implements HookAttributeInterface
{
    public function __construct(
        private readonly string $hook,
        private readonly int $priority = 10,
        private readonly int $acceptedArgs = 1,
        private readonly ?bool $config = null
    ) {
    }

    abstract protected function hook(): HookInterface;

    final public function add(\Closure $callback): void
    {
        $this->hook()->add(
            hook: $this->config ? config($this->hook) : $this->hook,
            callback: $callback,
            priority: $this->priority,
            acceptedArgs: $this->acceptedArgs
        );
    }
}
