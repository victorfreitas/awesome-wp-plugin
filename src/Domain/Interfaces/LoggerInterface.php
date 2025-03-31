<?php

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface LoggerInterface extends \Psr\Log\LoggerInterface
{
    public function withName(string $name): self;
}
