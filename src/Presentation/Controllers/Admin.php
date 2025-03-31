<?php

declare(strict_types=1);

namespace Awesome\Presentation\Controllers;

use Awesome\Application\Abstracts\Controller;
use Awesome\Infrastructure\Attributes\Action;
use Awesome\Infrastructure\Attributes\Filter;
use Awesome\Infrastructure\Facades\Dependency;
use Awesome\Infrastructure\Facades\Plugin;

final readonly class Admin extends Controller
{
    #[Filter(hook: 'admin_body_class')]
    public function bodyClasses(string $classes): string
    {
        if (! Plugin::isMainPage()) {
            return $classes;
        }

        return "{$classes} page-awesome";
    }

    #[Action(hook: 'admin_enqueue_scripts')]
    public function enqueueScripts(): void
    {
        Dependency::addStyle('admin', 'admin');
        Dependency::addScript('admin', 'admin');
    }
}
