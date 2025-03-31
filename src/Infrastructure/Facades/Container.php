<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Facades;

use Awesome\Domain\Interfaces\ContainerInterface;
use Awesome\Infrastructure\Exceptions\ContainerException;
use Awesome\Infrastructure\Exceptions\ContainerNotFoundException;
use Awesome\Infrastructure\Utils\Map;

final readonly class Container implements ContainerInterface
{
    public function __construct(protected Map $bindings = new Map())
    {
    }

    public function bind(string $accessor, string|callable $concrete): self
    {
        $this->bindings->set(name: $accessor, value: $concrete);

        return $this;
    }

    public function make(string $accessor): object
    {
        $concrete = $this->get(id: $accessor);

        return match (true) {
            $concrete instanceof \Closure => $concrete(),
            \class_exists(\strval($concrete)) => new $concrete(),
            default => $this->throwContainerException(accessor: $accessor)
        };
    }

    public function bindMany(array $facades): self
    {
        foreach ($facades as $accessor => $concrete) {
            $this->bind(accessor: $accessor, concrete: $concrete);
        }

        return $this;
    }

    public function get(string $id): mixed
    {
        if (! $this->has(id: $id)) {
            $this->throwContainerNotFoundException(id: $id);
        }

        return $this->bindings->get(name: $id);
    }

    public function has(string $id): bool
    {
        return $this->bindings->has(name: $id);
    }

    public function boot(): void
    {
        Facade::changeContainer($this);
    }

    private function throwContainerException(string $accessor): void
    {
        throw new ContainerException(
            \esc_html(
                \sprintf(
                    // translators: %s is the identifier
                    \__('The %s identifier is not a valid class or closure.', 'awesome'),
                    $accessor
                )
            )
        );
    }

    private function throwContainerNotFoundException(string $id): void
    {
        throw new ContainerNotFoundException(
            \esc_html(
                \sprintf(
                    // translators: %s is the identifier
                    \__('No entry was found for %s identifier.', 'awesome'),
                    $id
                )
            )
        );
    }
}
