<?php

/**
 * Application class.
 *
 * @package Awesome\Application
 * @since   1.0.0
 */

declare(strict_types=1);

namespace Awesome\Application;

use Awesome\Domain\Interfaces\AppInterface;
use Awesome\Domain\Interfaces\ConfigInterface;
use Awesome\Domain\Interfaces\ControllerInterface;
use Awesome\Domain\Interfaces\LoggerInterface;
use Awesome\Infrastructure\Facades\HookRegistrar;

final class App implements AppInterface
{
    public function __construct(
        private readonly ConfigInterface $config,
        private readonly LoggerInterface $logger
    ) {
    }

    public function config(): ConfigInterface
    {
        return $this->config;
    }

    public function logger(): LoggerInterface
    {
        return $this->logger;
    }

    public function environment(): string
    {
        return $this->config->external(name: 'WP_ENVIRONMENT_TYPE', defaults: 'development');
    }

    public function isProduction(): bool
    {
        return $this->environment() === 'production';
    }

    public function isDevelopment(): bool
    {
        return $this->environment() === 'development';
    }

    public function isStaging(): bool
    {
        return $this->environment() === 'staging';
    }

    public function isTest(): bool
    {
        return $this->environment() === 'test';
    }

    public function boot(): void
    {
        $controllers = $this->config->fromRoot(name: 'controllers');

        foreach ($controllers as $class) :
            $reflected = new \ReflectionClass($class);

            if ($reflected->implementsInterface(ControllerInterface::class)) {
                HookRegistrar::run(\is_string($class) ? $reflected->newInstance() : $class);
                continue;
            }

            $this->logger->critical(
                \sprintf(
                    /* translators: 1: Controller name, 2: Interface name */
                    esc_html__('Controller %1$s must implement %2$s', 'awesome'),
                    $reflected->getName(),
                    ControllerInterface::class
                )
            );
        endforeach;
    }
}
