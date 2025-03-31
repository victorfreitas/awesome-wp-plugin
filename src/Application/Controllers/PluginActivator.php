<?php

declare(strict_types=1);

namespace Awesome\Application\Controllers;

use Awesome\Application\Abstracts\Controller;
use Awesome\Domain\Enums\Event;
use Awesome\Infrastructure\Attributes\On;
use Awesome\Infrastructure\Facades\Config;
use Awesome\Infrastructure\Facades\DatabaseManager;

final readonly class PluginActivator extends Controller
{
    #[On(event: Event::PluginActivation)]
    public function activate(): void
    {
        DatabaseManager::createTable(queries: Config::fromRoot(name: 'queries'));
    }

    #[On(event: Event::PluginDeactivation)]
    public function deactivate(): void
    {
    }
}
