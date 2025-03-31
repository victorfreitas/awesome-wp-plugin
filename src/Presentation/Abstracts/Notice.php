<?php

declare(strict_types=1);

namespace Awesome\Presentation\Abstracts;

use Awesome\Domain\Interfaces\NoticeInterface;
use Awesome\Infrastructure\Facades\HookRegistrar;

abstract class Notice
{
    public function __construct(protected readonly NoticeInterface $notice)
    {
    }

    public static function create(NoticeInterface $notice): void
    {
        HookRegistrar::run(new static($notice));
    }
}
