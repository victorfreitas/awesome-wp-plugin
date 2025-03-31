<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Supports;

use Awesome\Domain\Interfaces\HookAttributeInterface as Hook;
use Awesome\Domain\Interfaces\HookRegistrarInterface;

final readonly class HookRegistrar implements HookRegistrarInterface
{
    public function run(object|string $target): void
    {
        $reflection = new \ReflectionClass($target);
        $methods = $reflection->getMethods(\ReflectionMethod::IS_PUBLIC);
        $instance = is_string($target) ? $reflection->newInstance() : $target;

        foreach ($methods as $method) :
            $attributes = $method->getAttributes(Hook::class, \ReflectionAttribute::IS_INSTANCEOF);

            if (empty($attributes)) {
                continue;
            }

            $closure = $method->getClosure($instance);

            foreach ($attributes as $attribute) {
                $attribute->newInstance()->add($closure);
            }
        endforeach;
    }
}
