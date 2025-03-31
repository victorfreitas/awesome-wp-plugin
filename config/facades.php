<?php

/**
 * Facades config.
 *
 * @package    Awesome
 * @subpackage config
 * @since      1.0.0
 */

declare(strict_types=1);

return [
    'system' => Awesome\Infrastructure\Utils\System::class,
    'action' => Awesome\Application\Hooks\Action::class,
    'filter' => Awesome\Application\Hooks\Filter::class,
    'option' => Awesome\Infrastructure\Services\Option::class,
    'database.manager' => Awesome\Infrastructure\Repositories\DatabaseManager::class,
    'dependency' => Awesome\Presentation\Utils\Dependency::class,
    'plugin' => Awesome\Presentation\Utils\Plugin::class,
    'hook.registrar' => Awesome\Infrastructure\Supports\HookRegistrar::class,
    'util.require.file' => Awesome\Infrastructure\Utils\RequireFile::class,
];
