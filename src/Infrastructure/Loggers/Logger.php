<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Loggers;

use Awesome\Domain\Interfaces\LoggerInterface;
use Monolog\Handler\StreamHandler;

use function Awesome\env;

final class Logger extends \Monolog\Logger implements LoggerInterface
{
    public function withName(string $name): self
    {
        return parent::withName($name);
    }

    private static function isEnabled(): bool
    {
        return env(name: 'WP_DEBUG') === true && env(name: 'WP_DEBUG_LOG') === true;
    }

    public static function create(string $name): LoggerInterface
    {
        if (! self::isEnabled()) {
            return new NullLogger();
        }

        $logger = new self(name: $name);
        $file = env('WP_CONTENT_DIR') . '/debug.log';

        $logger->pushHandler(new StreamHandler($file, \Monolog\Level::Debug));

        return $logger;
    }
}
