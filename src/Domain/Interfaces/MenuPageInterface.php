<?php

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface MenuPageInterface
{
    public function title(): string;

    public function slug(): string;

    public function capability(): string;

    public function icon(): string;

    public function position(): ?int;

    public function menuTitle(): string;

    public function callback(): \Closure;
}
