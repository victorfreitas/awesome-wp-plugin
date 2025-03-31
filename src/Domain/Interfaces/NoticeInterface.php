<?php

declare(strict_types=1);

namespace Awesome\Domain\Interfaces;

interface NoticeInterface
{
    public function message(): string;

    public function type(): string;

    public function isDismissible(): bool;
}
