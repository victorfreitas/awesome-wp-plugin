<?php

declare(strict_types=1);

namespace Awesome\Presentation\Dto;

use Awesome\Domain\Interfaces\PageInterface;

final readonly class Page implements PageInterface
{
    public function __construct(
        private string $title,
        private string $description,
        private string $slug
    ) {
    }

    public function title(): string
    {
        return $this->title;
    }

    public function description(): string
    {
        return $this->description;
    }

    public function slug(): string
    {
        return $this->slug;
    }
}
