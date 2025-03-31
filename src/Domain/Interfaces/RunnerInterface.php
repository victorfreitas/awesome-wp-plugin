<?php

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface RunnerInterface
{
    public function run(): bool;
}
