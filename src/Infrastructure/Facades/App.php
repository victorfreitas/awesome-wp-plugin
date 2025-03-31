<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Facades;

/**
 * App facade.
 *
 * @see \Awesome\Application\App
 *
 * @method static \Awesome\Domain\Interfaces\LoggerInterface logger()
 * @method static \Awesome\Domain\Interfaces\ConfigInterface config()
 */
class App extends Facade
{
    protected static function facadeAccessor(): string
    {
        return 'app';
    }
}
