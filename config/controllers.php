<?php

/**
 * Controllers config.
 *
 * @package    Awesome
 * @subpackage config
 * @since      1.0.0
 */

declare(strict_types=1);

return [
    Awesome\Application\Controllers\Email::class,
    Awesome\Application\Controllers\PluginActivator::class,
    Awesome\Presentation\Controllers\Page::class,
    Awesome\Presentation\Controllers\Admin::class,
];
