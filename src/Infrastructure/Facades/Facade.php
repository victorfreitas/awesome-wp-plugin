<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Facades;

abstract class Facade
{
    protected static Container $container;

    abstract protected static function facadeAccessor(): string;

    private static function resolveFacadeInstance(string $accessor): object
    {
        static $instances = [];

        return $instances[$accessor] ??= static::$container->make(accessor: $accessor);
    }

    public static function changeContainer(Container $container): void
    {
        static::$container = $container;
    }

    public static function __callStatic(string $method, array $args): mixed
    {
        $instance = static::resolveFacadeInstance(accessor: static::facadeAccessor());

        if (! method_exists(object_or_class: $instance, method: $method)) {
            throw new \RuntimeException(
                message: sprintf(
                    'Facade method %s::%s does not exist.',
                    static::class,
                    $method // phpcs:ignore WordPress.Security.EscapeOutput.ExceptionNotEscaped
                )
            );
        }

        return $instance->{$method}(...$args);
    }
}
