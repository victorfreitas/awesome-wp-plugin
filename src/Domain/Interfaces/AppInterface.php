<?php

/**
 * App Interface
 *
 * @package Awesome\Domain\Interfaces
 * @since   1.0.0
 */

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface AppInterface extends BootableInterface
{
    public function config(): ConfigInterface;

    public function logger(): LoggerInterface;

    public function environment(): string;

    public function isProduction(): bool;

    public function isDevelopment(): bool;

    public function isStaging(): bool;

    public function isTest(): bool;
}
