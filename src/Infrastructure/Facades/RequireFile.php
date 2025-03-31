<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Facades;

class RequireFile extends Facade
{
    protected static function facadeAccessor(): string
    {
        return 'util.require.file';
    }
}
