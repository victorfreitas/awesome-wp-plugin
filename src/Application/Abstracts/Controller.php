<?php

declare(strict_types=1);

namespace Awesome\Application\Abstracts;

use Awesome\Domain\Interfaces\ControllerInterface;

abstract readonly class Controller implements ControllerInterface
{
    public function __construct()
    {
        $this->initialize();
    }

    protected function initialize(): void
    {
    }
}
