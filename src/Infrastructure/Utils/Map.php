<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Utils;

use Awesome\Domain\Interfaces\MapInterface;

class Map extends \ArrayObject implements MapInterface
{
    public function __construct(array $items = [])
    {
        parent::__construct(
            array: $items,
            flags: \ArrayObject::ARRAY_AS_PROPS,
            iteratorClass: 'ArrayIterator'
        );
    }

    public function set(string $name, mixed $value): self
    {
        $this->offsetSet($name, $value);

        return $this;
    }

    public function get(string $name, mixed $defaults = null): mixed
    {
        if (! $this->has(name: $name)) {
            return $defaults;
        }

        return $this->offsetGet($name) ?? $defaults;
    }

    public function has(string $name): bool
    {
        return $this->offsetExists($name);
    }
}
