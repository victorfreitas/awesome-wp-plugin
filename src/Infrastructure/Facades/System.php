<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Facades;

/**
 * System facade.
 *
 * @method static bool checkPhpVersion()
 * @method static bool isWooCommerce()
 */
class System extends Facade
{
    protected static function facadeAccessor(): string
    {
        return 'system';
    }
}
