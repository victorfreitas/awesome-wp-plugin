<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Abstracts;

use Awesome\Domain\Enums\Event;
use Awesome\Domain\Interfaces\HookAttributeInterface;
use Awesome\Infrastructure\Exceptions\InvalidArgumentException;
use Awesome\Infrastructure\Facades\Action;

use function Awesome\config;

abstract class EventAttribute implements HookAttributeInterface
{
    public function __construct(private readonly \BackedEnum $event)
    {
    }

    final public function add(\Closure $callback): void
    {
        $method = match ($this->event) {
            Event::PluginActivation => 'registerActivation',
            Event::PluginDeactivation => 'registerDeactivation',
            default => 'throwInvalidEventNameNotice'
        };

        $this->{$method}($callback);
    }

    final protected function registerActivation(\Closure $callback): void
    {
        Action::registerActivation(file: config('plugin.file'), callback: $callback);
    }

    final protected function registerDeactivation(\Closure $callback): void
    {
        Action::registerDeactivation(file: config('plugin.file'), callback: $callback);
    }

    final protected function throwInvalidEventNameNotice(): void
    {
        throw new InvalidArgumentException(
            \sprintf(
                /* translators: %s: event name */
                \esc_html__('Invalid attribute event name: %s', 'awesome'),
                \esc_html($this->event->value)
            )
        );
    }
}
