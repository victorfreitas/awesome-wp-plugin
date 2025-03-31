<?php

declare(strict_types=1);

namespace Awesome\Infrastructure\Loggers;

use Awesome\Domain\Interfaces\LoggerInterface;

final class NullLogger extends \Psr\Log\NullLogger implements LoggerInterface
{
    protected readonly string $name;

    public function withName(string $name): self
    {
        $this->name = $name;

        return $this;
    }
}
