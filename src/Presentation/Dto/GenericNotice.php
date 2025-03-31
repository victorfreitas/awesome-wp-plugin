<?php

declare(strict_types=1);

namespace Awesome\Presentation\Dto;

use Awesome\Domain\Interfaces\NoticeInterface;

final readonly class GenericNotice implements NoticeInterface
{
    public function __construct(
        private string $message,
        private string $type = 'info',
        private bool $dismissible = true
    ) {
    }

    public function message(): string
    {
        return $this->message;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function isDismissible(): bool
    {
        return $this->dismissible;
    }
}
