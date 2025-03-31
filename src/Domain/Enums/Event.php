<?php

declare(strict_types=1);

namespace Awesome\Domain\Enums;

enum Event: string
{
    case PluginActivation = 'plugin.activation';
    case PluginDeactivation = 'plugin.deactivation';
}
