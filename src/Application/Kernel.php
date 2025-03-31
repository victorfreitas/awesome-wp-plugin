<?php

declare(strict_types=1);

namespace Awesome\Application;

use Awesome\Domain\Interfaces\RunnerInterface;
use Awesome\Infrastructure\Facades\Container;
use Awesome\Domain\Interfaces\AppInterface;
use Awesome\Domain\Interfaces\ConfigInterface;
use Awesome\Domain\Interfaces\ContainerInterface;
use Awesome\Domain\Interfaces\LoggerInterface;
use Awesome\Infrastructure\Loggers\Logger;
use Awesome\Infrastructure\Utils\Map;

final class Kernel implements RunnerInterface
{
    public function __construct(
        private readonly AppInterface $app,
        private readonly ConfigInterface $config,
        private readonly ContainerInterface $container,
        private readonly LoggerInterface $logger
    ) {
    }

    private static function createBootArgs(array $context): array
    {
        $logger = Logger::create('kernel');
        $config = new Config(pluginFile: $context['plugin.file']);
        $app = new App(config: $config, logger: $logger->withName('app'));
        $container = new Container(bindings: new Map($config->fromRoot(name: 'facades')));

        return [$app, $config, $container, $logger];
    }

    public static function boot(array $context, ?\Closure $createArgs = null): bool
    {
        [$app, $config, $container, $logger] = $createArgs ? $createArgs() : self::createBootArgs($context);

        $container->bind('app', static fn () => $app);
        $container->bind('config', static fn () => $config);

        $kernel = new self(app: $app, config: $config, container: $container, logger: $logger);

        return $kernel->run();
    }

    public function run(): bool
    {
        try {
            $this->container->boot();
            $this->config->boot();
            $this->app->boot();

            return true;
        } catch (\Throwable $error) {
            $this->logger->error($error->getMessage(), ['exception' => $error]);

            return false;
        }
    }
}
