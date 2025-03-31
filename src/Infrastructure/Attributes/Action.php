<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Attributes;

use Awesome\Domain\Interfaces\HookInterface;
use Awesome\Application\Hooks;
use Awesome\Infrastructure\Abstracts\HookAttribute;

#[\Attribute(\Attribute::TARGET_METHOD)]
final class Action extends HookAttribute
{
    protected function hook(): HookInterface
    {
        return new Hooks\Action();
    }
}
