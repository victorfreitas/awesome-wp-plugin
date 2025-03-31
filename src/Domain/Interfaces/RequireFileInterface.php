<?php

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface RequireFileInterface
{
    public function once(string $path): void;
}
