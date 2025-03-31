<?php

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface PageInterface
{
    public function title(): string;

    public function description(): string;

    public function slug(): string;
}
