<?php

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface LinkInterface
{
    public function url(): string;

    public function title(): string;
}
