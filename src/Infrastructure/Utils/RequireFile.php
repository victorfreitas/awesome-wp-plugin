<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Utils;

use Awesome\Domain\Interfaces\RequireFileInterface;

final readonly class RequireFile implements RequireFileInterface
{
    public function once(string $path): void
    {
        require_once $path;
    }
}
