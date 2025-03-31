<?php

declare(strict_types=1);

namespace Awesome;

use Awesome\Infrastructure\Facades\Config;
use Awesome\Domain\Interfaces\ViewInterface;

function config(string $name, mixed $defaults = null): mixed
{
    return Config::get(name: $name, defaults: $defaults);
}

function createView(ViewInterface $view): \Closure
{
    return static function () use ($view): void {
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Expected to be escaped in the view.
        echo $view->render();
    };
}

function env(string $name, mixed $defaults = null): mixed
{
    $value = match (true) {
        defined($name) => constant($name),
        getenv($name) !== false => getenv($name),
        default => $defaults,
    };

    return match ($value) {
        'true', 'TRUE', 'True' => true,
        'false', 'FALSE', 'False' => false,
        'null', 'NULL', 'Null' => null,
        default => $value,
    };
}
