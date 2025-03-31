<?php

/**
 * Bootable Interface
 *
 * @package Awesome\Domain\Interfaces
 * @since   1.0.0
 */

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface BootableInterface
{
    public function boot(): void;
}
