<?php

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface ViewInterface extends \Stringable
{
    public function render(): string;
}
