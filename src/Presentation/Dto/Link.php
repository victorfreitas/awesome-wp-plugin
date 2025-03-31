<?php

declare(strict_types=1);

namespace Awesome\Presentation\Dto;

use Awesome\Domain\Interfaces\LinkInterface;

final readonly class Link implements LinkInterface
{
    public function __construct(private string $url, private string $title)
    {
    }

    public function url(): string
    {
        return $this->url;
    }

    public function title(): string
    {
        return $this->title;
    }
}
